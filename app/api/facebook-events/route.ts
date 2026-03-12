import { NextResponse } from 'next/server';
import { fetchFacebookEvents } from '@/lib/facebook';

export async function GET() {
  try {
    const events = await fetchFacebookEvents();
    return NextResponse.json({ events }, { status: 200 });
  } catch (error) {
    const message = error instanceof Error ? error.message : 'Unknown error';
    return NextResponse.json({ error: message }, { status: 500 });
  }
}
