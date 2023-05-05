import initContent from './features/content'

declare global {
  interface Window {
    makaira: { domain: string; instance: string }
  }
}

function initMakaira() {
  const domain =
    process.env.NODE_ENV === 'development' ? 'https://demo.makaira.io' : 'https://{{domain}}'

  const instance = process.env.NODE_ENV === 'development' ? 'storefront' : '{{instance}}'

  window.makaira = { domain, instance }
}

initMakaira()
initContent()
