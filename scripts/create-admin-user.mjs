import { createClient } from '@supabase/supabase-js';

const supabaseUrl = process.env.NEXT_PUBLIC_SUPABASE_URL;
const serviceRoleKey = process.env.SUPABASE_SERVICE_ROLE_KEY;
const adminEmail = process.env.ADMIN_EMAIL;
const adminPassword = process.env.ADMIN_PASSWORD;

if (!supabaseUrl || !serviceRoleKey) {
  throw new Error('Missing NEXT_PUBLIC_SUPABASE_URL or SUPABASE_SERVICE_ROLE_KEY');
}

if (!adminEmail || !adminPassword) {
  throw new Error('Missing ADMIN_EMAIL or ADMIN_PASSWORD');
}

const supabase = createClient(supabaseUrl, serviceRoleKey, {
  auth: {
    autoRefreshToken: false,
    persistSession: false
  }
});

const { data: existingUsers, error: listError } = await supabase.auth.admin.listUsers();
if (listError) {
  throw new Error(`Unable to list users: ${listError.message}`);
}

const existingAdmin = existingUsers.users.find((user) => user.email === adminEmail);

if (existingAdmin) {
  console.log(`Admin user already exists: ${adminEmail}`);
  process.exit(0);
}

const { data, error } = await supabase.auth.admin.createUser({
  email: adminEmail,
  password: adminPassword,
  email_confirm: true,
  user_metadata: {
    role: 'admin'
  }
});

if (error) {
  throw new Error(`Unable to create admin user: ${error.message}`);
}

console.log(`Admin user created successfully: ${data.user?.email}`);
