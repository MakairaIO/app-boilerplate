import fetchFromMakaira from './fetchFromMakaira'
import EndpointType from '../enums/EndpointType'

export default async function fetchPageData() {
  const url = window.location.pathname

  const body = {
    isSearch: false,
    url: encodeURI(url),
    constraints: {
      'query.shop_id': 1,
      'query.use_stock': true,
      'query.original_keys': true,
    },
  }

  return fetchFromMakaira(body, EndpointType.page)
}
