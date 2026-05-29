import InteractiveSentence from '@/components/recommendations/InteractiveSentence';
import { useLang } from '@/lib/useLang';
import { home } from '@/routes';
import { store } from '@/routes/recommendations';
import type { RecommendationAnswers } from '@/types/recommendations';
import { Head, Link, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';

const emptyAnswers: RecommendationAnswers = {
    budget: '',
    usage: '',
    family_size: '',
    monthly_km: '',
    fuel_type: '',
    body_type: '',
    transmission: '',
    priority: '',
};

type RecommendationFormPageProps = {
    previousAnswers?: RecommendationAnswers | null;
};

export default function RecommendationFormPage({ previousAnswers }: RecommendationFormPageProps) {
    const lang = useLang();
    const form = useForm<RecommendationAnswers>(previousAnswers ?? emptyAnswers);

    const isComplete = Object.values(form.data).every(Boolean);

    function submit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();

        if (!isComplete) {
            return;
        }

        form.post(store.url());
    }

    return (
        <>
            <Head title={lang.page_titles.form} />
            <main className="min-h-screen bg-[#f8f5ef] px-6 py-8 text-[#101828]">
                <header className="mx-auto flex max-w-6xl items-center justify-between">
                    <Link
                        href={home()}
                        className="text-sm font-semibold text-[#0d433c]"
                    >
                        {lang.form.logo}
                    </Link>
                    <p className="text-sm text-[#667085]">{lang.form.step}</p>
                </header>

                <form
                    onSubmit={submit}
                    className="mx-auto flex min-h-[78vh] max-w-6xl flex-col justify-center"
                >
                    <InteractiveSentence
                        answers={form.data}
                        errors={form.errors}
                        onChange={(field, value) =>
                            form.setData({ ...form.data, [field]: value })
                        }
                    />

                    <div className="mt-12 flex justify-center">
                        <button
                            type="submit"
                            disabled={!isComplete || form.processing}
                            className="min-h-12 rounded-md bg-[#101828] px-7 text-base font-semibold text-white transition hover:bg-[#263244] focus:ring-4 focus:ring-[#98a2b3] focus:outline-none disabled:cursor-not-allowed disabled:bg-[#98a2b3]"
                        >
                            {form.processing
                                ? lang.form.submit_loading
                                : lang.form.submit_idle}
                        </button>
                    </div>
                </form>
            </main>
        </>
    );
}
