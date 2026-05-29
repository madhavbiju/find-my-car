import { useLang } from '@/lib/useLang';
import type { Recommendation } from '@/types/recommendations';

type RecommendationCardProps = {
    recommendation: Recommendation;
};

const currency = new Intl.NumberFormat('en-IN', {
    style: 'currency',
    currency: 'INR',
    maximumFractionDigits: 0,
});

export default function RecommendationCard({
    recommendation,
}: RecommendationCardProps) {
    const lang = useLang();
    const { card } = lang;

    function label(value: string | null) {
        return value ? value.replace('-', ' ') : card.not_specified;
    }

    return (
        <article className="rounded-md border border-[#d8d2c4] bg-white p-5 shadow-sm">
            <div className="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p className="text-sm font-semibold text-[#b45309]">
                        {card.rank.replace(':rank', String(recommendation.rank))}
                    </p>
                    <h2 className="mt-1 text-2xl font-semibold text-[#101828]">
                        {recommendation.make} {recommendation.model}
                    </h2>
                    <p className="mt-1 text-sm text-[#667085]">
                        {recommendation.variant}
                    </p>
                </div>
                <div className="w-fit rounded-md bg-[#0d433c] px-4 py-3 text-white">
                    <p className="text-3xl font-semibold">
                        {recommendation.match_percentage}%
                    </p>
                    <p className="text-xs font-medium tracking-wide uppercase">
                        {card.match_label}
                    </p>
                </div>
            </div>

            <dl className="mt-5 grid gap-3 text-sm sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <dt className="text-[#667085]">{card.price_label}</dt>
                    <dd className="font-semibold text-[#101828]">
                        {currency.format(recommendation.price)}
                    </dd>
                </div>
                <div>
                    <dt className="text-[#667085]">{card.mileage_label}</dt>
                    <dd className="font-semibold text-[#101828]">
                        {recommendation.mileage} {card.mileage_unit}
                    </dd>
                </div>
                <div>
                    <dt className="text-[#667085]">{card.safety_label}</dt>
                    <dd className="font-semibold text-[#101828]">
                        {recommendation.safety_rating}{card.safety_suffix}
                    </dd>
                </div>
                <div>
                    <dt className="text-[#667085]">{card.body_label}</dt>
                    <dd className="font-semibold text-[#101828] capitalize">
                        {label(recommendation.body_type)}
                    </dd>
                </div>
            </dl>

            <dl className="mt-5 grid gap-2 rounded-md bg-[#f6f3eb] p-4 text-sm sm:grid-cols-3">
                <div>
                    <dt className="text-[#667085]">{card.airbags_label}</dt>
                    <dd className="font-semibold">
                        {recommendation.specifications.airbags ?? card.na}
                    </dd>
                </div>
                <div>
                    <dt className="text-[#667085]">{card.power_label}</dt>
                    <dd className="font-semibold">
                        {recommendation.specifications.power_bhp ?? card.na} {card.power_unit}
                    </dd>
                </div>
                <div>
                    <dt className="text-[#667085]">{card.fuel_gearbox_label}</dt>
                    <dd className="font-semibold capitalize">
                        {label(recommendation.specifications.fuel_type)} /{' '}
                        {label(recommendation.specifications.transmission)}
                    </dd>
                </div>
            </dl>

            <div className="mt-5">
                <h3 className="text-sm font-semibold text-[#101828]">
                    {card.why_recommend}
                </h3>
                <ul className="mt-3 space-y-2 text-sm text-[#344054]">
                    {recommendation.explanation.map((reason) => (
                        <li key={reason} className="flex gap-2">
                            <span className="mt-2 h-1.5 w-1.5 rounded-full bg-[#146c5f]" />
                            <span>{reason}</span>
                        </li>
                    ))}
                </ul>
            </div>

            {recommendation.warnings.length > 0 && (
                <div className="mt-5 rounded-md border border-[#facc15] bg-[#fffbeb] p-4">
                    <h3 className="text-sm font-semibold text-[#854d0e]">
                        {card.concerns_heading}
                    </h3>
                    <ul className="mt-3 space-y-2 text-sm text-[#713f12]">
                        {recommendation.warnings.map((warning) => (
                            <li
                                key={`${warning.label}-${warning.message}`}
                                className="flex gap-2"
                            >
                                <span className="mt-2 h-1.5 w-1.5 rounded-full bg-[#ca8a04]" />
                                <span>
                                    <span className="font-semibold">
                                        {warning.label}:
                                    </span>{' '}
                                    {warning.message}
                                </span>
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </article>
    );
}
