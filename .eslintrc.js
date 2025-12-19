module.exports = {
    parser: '@typescript-eslint/parser',
    plugins: ['@typescript-eslint'],
    extends: [
        'eslint:recommended',
        'plugin:@typescript-eslint/recommended',
    ],
    rules: {
        'semi': ['error', 'always'],
        '@typescript-eslint/semi': ['error', 'always'],

        "brace-style": ["error", "1tbs", { "allowSingleLine": true }],

        'no-extra-semi': 'error',
        '@typescript-eslint/no-extra-semi': 'error',

        '@typescript-eslint/member-delimiter-style': [
            'error',
            {
                multiline: {
                    delimiter: 'semi',
                    requireLast: true
                },
                singleline: {
                    delimiter: 'semi',
                    requireLast: false
                }
            }
        ]
    }
};
