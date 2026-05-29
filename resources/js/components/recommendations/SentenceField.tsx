import { cn } from '@/lib/utils';
import type { SentenceOption } from '@/types/recommendations';
import { useId, useState } from 'react';

type SentenceFieldProps = {
    label: string;
    value: string;
    placeholder: string;
    options: SentenceOption[];
    onChange: (value: string) => void;
};

export default function SentenceField({
    label,
    value,
    placeholder,
    options,
    onChange,
}: SentenceFieldProps) {
    const [isOpen, setIsOpen] = useState(false);
    const listboxId = useId();
    const selectedOption = options.find((option) => option.value === value);

    return (
        <span className="relative inline-flex">
            <button
                type="button"
                aria-expanded={isOpen}
                aria-haspopup="listbox"
                aria-controls={listboxId}
                className={cn(
                    'mx-1 inline-flex min-h-11 items-center rounded-md border px-3 py-1.5 text-left text-2xl font-semibold transition focus:ring-4 focus:outline-none sm:text-3xl',
                    selectedOption
                        ? 'border-[#146c5f] bg-[#e9f8f3] text-[#0d433c] focus:ring-[#b6e4d9]'
                        : 'border-[#b45309] bg-[#fff7ed] text-[#9a3412] focus:ring-[#fed7aa]',
                )}
                onClick={() => setIsOpen((open) => !open)}
            >
                {selectedOption?.label ?? placeholder}
            </button>

            {isOpen && (
                <span
                    id={listboxId}
                    role="listbox"
                    aria-label={label}
                    className="absolute top-full left-1 z-20 mt-2 max-h-72 w-64 overflow-auto rounded-md border border-[#d8d2c4] bg-white p-1 text-base shadow-xl"
                >
                    {options.map((option) => (
                        <button
                            key={option.value}
                            type="button"
                            role="option"
                            aria-selected={option.value === value}
                            className={cn(
                                'block w-full rounded px-3 py-2 text-left text-sm font-medium text-[#1f2933] hover:bg-[#edf7f4] focus:bg-[#edf7f4] focus:outline-none',
                                option.value === value &&
                                    'bg-[#d7f0e8] text-[#0d433c]',
                            )}
                            onClick={() => {
                                onChange(option.value);
                                setIsOpen(false);
                            }}
                        >
                            {option.label}
                        </button>
                    ))}
                </span>
            )}
        </span>
    );
}
