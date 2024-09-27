/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/*.{html,js,php}", "./App/partials/*.php"],
  theme: {
    extend: {
      rotate: {
        '270': '270deg',
      },
      backgroundImage: {
        'leavesLeft': "url('/images/leaves-Border-left-1.png')",
        'leavesRight': "url('/images/leaves-Border-right-1.png')",
      },
      colors: {
        'line-brown': '#B16119',
        'submit-red': '#BF4342',
        'input-cream': '#FFF5E1',
        'text-box-colour': '#C7CFAB',
        'input-text': '#67360A',
      },
    },
  },
  plugins: [],
}

