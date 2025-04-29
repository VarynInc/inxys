const config = {
    testEnvironment: "jest-fixed-jsdom",
    testPathIgnorePatterns: ["testapp.js"],
    testMatch: ["**/*.test.(js|ts|cjs|mjs)"],
    verbose: true
};
module.exports = async () => {
    process.env.TZ = 'GMT'
}
module.exports = config;
