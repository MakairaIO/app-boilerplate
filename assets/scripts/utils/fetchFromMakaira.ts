import EndpointType from '../enums/EndpointType'

export default async function fetchFromMakaira(body = {}, endpoint: EndpointType) {
  const baseUrl = window.makaira.domain
  const url = `${baseUrl}${endpoint}`

  const headers = new Headers({
    'Content-Type': 'application/json',
    'X-Makaira-Instance': window.makaira.instance,
  })

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers,
      body: JSON.stringify(body),
    })

    return response.json()
  } catch (error) {
    console.error(error)
  }
}
