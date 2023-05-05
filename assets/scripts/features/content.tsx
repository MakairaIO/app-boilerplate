import React from 'react'
import { createRoot } from 'react-dom/client'
import PageContent from './PageContent'

export default function initContent() {
  const container = document.querySelector('#makaira-content')

  if (!container) {
    return
  }

  const root = createRoot(container)

  root.render(<PageContent />)
}
