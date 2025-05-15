<?php

namespace Hariadi\Siapa\Support;

class SiapaLists
{
    public const SALUTATIONS = [
        "dato' dr. ir. hj.",
        "dato' dr. ir.",
        'dr. ir. hj.',
        "tan sri dato'",
        'tan sri haji',
        'tan sri',
        'toh puan',
        "dato' sri",
        "dato' seri",
        'datuk seri',
        'datuk dr. ir.',
        'datuk dr.',
        'datuk',
        'datin dr. ir.',
        'datin dr.',
        "dato' dr.",
        "dato'",
        'datin',
        'puan sri',
        'puan',
        'cik',
        'en.',
        'pn.',
        'dr.',
        'hj.',
        'ir.',
    ];

    public const MIDDLES = ['von', 'bin', 'binti', 'bte', 'a/l', 'a/p', 'mohd', 'syed'];
    public const FEMALE_PATTERNS = ['puan', 'cik', 'hajah', 'pn.', 'bt.', 'bte.'];
}
