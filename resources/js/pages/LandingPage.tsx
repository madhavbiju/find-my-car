import { useLang } from '@/lib/useLang';
import { create } from '@/routes/recommendations';
import { Head, Link } from '@inertiajs/react';

export default function LandingPage() {
    const lang = useLang();
    const { landing } = lang;

    return (
        <>
            <Head title={lang.page_titles.landing} />
            <main className="min-h-screen bg-[#f8f5ef] text-[#101828]">
                <section
                    className="relative flex min-h-[92vh] items-center bg-cover bg-center"
                    style={{
                        backgroundImage:
                            "linear-gradient(90deg, rgba(16,24,40,0.84), rgba(16,24,40,0.42)), url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1800&q=85')",
                    }}
                >
                    <div className="mx-auto w-full max-w-6xl px-6 py-20">
                        <div className="max-w-3xl text-white">
                            <p className="text-sm font-semibold tracking-[0.22em] text-[#facc15] uppercase">
                                {landing.eyebrow}
                            </p>
                            <h1 className="mt-5 text-5xl leading-tight font-semibold sm:text-7xl">
                                {landing.hero_title}
                            </h1>
                            <p className="mt-6 max-w-2xl text-lg leading-8 text-[#f2f4f7]">
                                {landing.hero_description}
                            </p>
                            <Link
                                href={create()}
                                className="mt-10 inline-flex min-h-12 items-center rounded-md bg-[#facc15] px-6 text-base font-semibold text-[#101828] transition hover:bg-[#fde047] focus:ring-4 focus:ring-[#fef08a] focus:outline-none"
                            >
                                {landing.cta_button}
                            </Link>
                        </div>
                    </div>
                </section>

                <section className="mx-auto grid max-w-6xl gap-6 px-6 py-10 md:grid-cols-3">
                    {landing.features.map((feature) => (
                        <div
                            key={feature.title}
                            className="border-t border-[#d8d2c4] pt-5"
                        >
                            <h2 className="text-lg font-semibold">{feature.title}</h2>
                            <p className="mt-2 text-sm leading-6 text-[#475467]">
                                {feature.description}
                            </p>
                        </div>
                    ))}
                </section>
            </main>
        </>
    );
}
