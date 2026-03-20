/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    remotePatterns: [
      { protocol: 'https', hostname: 'images.unsplash.com' },
      { protocol: 'https', hostname: 'scontent.xx.fbcdn.net' },
      { protocol: 'https', hostname: 'lookaside.fbsbx.com' }
    ]
  }
};

export default nextConfig;
