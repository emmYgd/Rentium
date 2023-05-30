/** @type {import('next').NextConfig} */
const nextConfig = {
    //redirect:
    async redirects()
    {
        return[
            {
                source: '/',
                destination: '/controllers/general/about-us',
                permanent: true,
            },
        ]
    }
}

module.exports = nextConfig
