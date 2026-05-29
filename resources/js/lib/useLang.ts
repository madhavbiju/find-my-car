import type { RecommendationsLang } from '@/types/recommendations';
import { usePage } from '@inertiajs/react';

export function useLang(): RecommendationsLang {
    return usePage().props.lang.recommendations;
}
