module.exports = {
    preset: 'ts-jest',
    testEnvironment: 'node',

    globals: {
        'ts-jest': {
            tsconfig: 'tsconfig.test.json'
        }
    },

    roots: ['<rootDir>/tests', '<rootDir>/src'],

    moduleDirectories: ['node_modules', 'src'],

    testMatch: [
        '<rootDir>/tests/Unit/**/*.test.ts',
        '<rootDir>/tests/**/**/*.spec.ts'
    ],

    transform: {
        '^.+\\.ts$': 'ts-jest'
    },
    testPathIgnorePatterns: ['/node_modules/'],
};
