import SentenceField from '@/components/recommendations/SentenceField';
import { useLang } from '@/lib/useLang';
import type {
    RecommendationAnswers,
    SentenceOption,
} from '@/types/recommendations';

type InteractiveSentenceProps = {
    answers: RecommendationAnswers;
    errors: Partial<Record<keyof RecommendationAnswers, string>>;
    onChange: (field: keyof RecommendationAnswers, value: string) => void;
};

function toOptions(map: Record<string, string>): SentenceOption[] {
    return Object.entries(map).map(([value, label]) => ({ value, label }));
}

export default function InteractiveSentence({
    answers,
    errors,
    onChange,
}: InteractiveSentenceProps) {
    const lang = useLang();
    const { sentence, fields, options } = lang;

    return (
        <div className="mx-auto max-w-5xl text-center">
            <p className="text-3xl leading-[1.75] font-medium text-balance text-[#1f2933] sm:text-4xl">
                {sentence.part1_prefix}
                <SentenceField
                    label={fields.budget.label}
                    value={answers.budget}
                    placeholder={fields.budget.placeholder}
                    options={toOptions(options.budget)}
                    onChange={(value) => onChange('budget', value)}
                />
                {sentence.part1_usage_prefix}
                <SentenceField
                    label={fields.usage.label}
                    value={answers.usage}
                    placeholder={fields.usage.placeholder}
                    options={toOptions(options.usage)}
                    onChange={(value) => onChange('usage', value)}
                />
                {sentence.part1_family_prefix}
                <SentenceField
                    label={fields.family_size.label}
                    value={answers.family_size}
                    placeholder={fields.family_size.placeholder}
                    options={toOptions(options.family_size)}
                    onChange={(value) => onChange('family_size', value)}
                />
                .
            </p>

            <p className="mt-8 text-3xl leading-[1.75] font-medium text-balance text-[#1f2933] sm:text-4xl">
                {sentence.part2_km_prefix}
                <SentenceField
                    label={fields.monthly_km.label}
                    value={answers.monthly_km}
                    placeholder={fields.monthly_km.placeholder}
                    options={toOptions(options.monthly_km)}
                    onChange={(value) => onChange('monthly_km', value)}
                />
                {sentence.part2_fuel_prefix}
                <SentenceField
                    label={fields.fuel_type.label}
                    value={answers.fuel_type}
                    placeholder={fields.fuel_type.placeholder}
                    options={toOptions(options.fuel_type)}
                    onChange={(value) => onChange('fuel_type', value)}
                />
                <SentenceField
                    label={fields.body_type.label}
                    value={answers.body_type}
                    placeholder={fields.body_type.placeholder}
                    options={toOptions(options.body_type)}
                    onChange={(value) => onChange('body_type', value)}
                />
                {sentence.part2_transmission_prefix}
                <SentenceField
                    label={fields.transmission.label}
                    value={answers.transmission}
                    placeholder={fields.transmission.placeholder}
                    options={toOptions(options.transmission)}
                    onChange={(value) => onChange('transmission', value)}
                />
                {sentence.part2_transmission_suffix}
                <SentenceField
                    label={fields.priority.label}
                    value={answers.priority}
                    placeholder={fields.priority.placeholder}
                    options={toOptions(options.priority)}
                    onChange={(value) => onChange('priority', value)}
                />
                {sentence.part2_suffix}
            </p>

            {Object.keys(errors).length > 0 && (
                <p className="mt-8 text-sm font-medium text-[#b42318]">
                    {lang.form.errors_incomplete}
                </p>
            )}
        </div>
    );
}
