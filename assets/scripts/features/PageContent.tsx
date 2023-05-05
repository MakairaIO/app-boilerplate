import { useEffect, useState } from 'react'
import fetchPageData from '../utils/fetchPageData'
import Page from '../contracts/Page'

export default function PageContent() {
  const [page, setPage] = useState<Page | null>(null)

  useEffect(() => {
    async function fetchPage() {
      const pageData = await fetchPageData()

      setPage(pageData)
    }

    fetchPage()
  }, [])

  if (!page?.data?.config?.main) {
    return null
  }

  return (
    <div>
      <h1>Page Content 2</h1>
    </div>
  )
}
