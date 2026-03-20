import { NextResponse } from 'next/server';

export async function POST(request) {
  const formData = await request.formData();
  const slug = String(formData.get('slug') || '');
  const name = String(formData.get('name') || '').trim();
  const email = String(formData.get('email') || '').trim();
  const phone = String(formData.get('phone') || '').trim();
  const danceRole = String(formData.get('dance_role') || '').trim();
  const notes = String(formData.get('notes') || '').trim();

  if (!slug || !name || !email) {
    return NextResponse.redirect(new URL(`/courses/${slug || 'lindy-hop-zaciatocnici'}/register?state=error`, request.url));
  }

  const webhookUrl = process.env.REGISTRATION_WEBHOOK_URL;

  if (webhookUrl) {
    await fetch(webhookUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ slug, name, email, phone, danceRole, notes, submittedAt: new Date().toISOString() })
    });
  }

  return NextResponse.redirect(new URL(`/courses/${slug}/register?state=success`, request.url));
}
