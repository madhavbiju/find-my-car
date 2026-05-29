import RecommendationCard from '@/components/recommendations/RecommendationCard';
import { useLang } from '@/lib/useLang';
import { create } from '@/routes/recommendations';
import type {
    Recommendation,
    RecommendationSession,
} from '@/types/recommendations';
import { Head, Link } from '@inertiajs/react';

type RecommendationResultsPageProps = {
    session: RecommendationSession;
    recommendations: Recommendation[];
};

export default function RecommendationResultsPage({
    session,
    recommendations,
}: RecommendationResultsPageProps) {
    const lang = useLang();
    const { results } = lang;

    return (
        <>
            <Head title={lang.page_titles.results} />
            <main className="min-h-screen bg-[#f8f5ef] px-6 py-8 text-[#101828]">
                <section className="mx-auto max-w-6xl">
                    <div className="flex flex-col gap-5 border-b border-[#d8d2c4] pb-8 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p className="text-sm font-semibold tracking-[0.18em] text-[#b45309] uppercase">
                                {results.eyebrow}
                            </p>
                            <h1 className="mt-3 text-4xl font-semibold sm:text-5xl">
                                {results.heading}
                            </h1>
                            <p className="mt-3 max-w-2xl text-base leading-7 text-[#475467]">
                                {results.subheading}
                            </p>
                        </div>
                        <Link
                            href={create.url({ query: { from: session.id } })}
                            className="inline-flex min-h-11 w-fit items-center rounded-md border border-[#0d433c] px-4 text-sm font-semibold text-[#0d433c] transition hover:bg-[#e9f8f3] focus:ring-4 focus:ring-[#b6e4d9] focus:outline-none"
                        >
                            {results.refine_button}
                        </Link>
                    </div>

                    {/* Disclaimer banner */}
                    <div className="mt-6 flex gap-3 rounded-md border border-[#fde68a] bg-[#fffbeb] px-4 py-3 text-sm text-[#92400e]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="mt-0.5 size-4 shrink-0">
                            <path fillRule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" clipRule="evenodd" />
                        </svg>
                        <div>
                            <p className="font-semibold">{results.disclaimer_title}</p>
                            <p className="mt-0.5 text-[#78350f]">{results.disclaimer_body}</p>
                        </div>
                    </div>

                    {recommendations.length > 0 ? (
                        <div className="mt-8 grid gap-5">
                            {recommendations.map((recommendation) => (
                                <RecommendationCard
                                    key={`${recommendation.rank}-${recommendation.make}-${recommendation.model}`}
                                    recommendation={recommendation}
                                />
                            ))}
                        </div>
                    ) : (
                        <div className="mt-10 rounded-md border border-[#d8d2c4] bg-white p-8 text-center">
                            <h2 className="text-2xl font-semibold">
                                {results.no_matches_title}
                            </h2>
                            <p className="mx-auto mt-3 max-w-xl text-sm leading-6 text-[#667085]">
                                {results.no_matches_description}
                            </p>
                        </div>
                    )}
                </section>
            </main>
        </>
    );
}
