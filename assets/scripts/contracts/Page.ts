interface MainConfig {
  elements: Array<unknown>
}

interface Data {
  id: string
  metadata: {
    keywords: string
    description: string
    title: string
  }
  self: {
    selfLinks: {
      [key: string]: string
    }
    navigation: any[]
  }
  config: {
    main: MainConfig
  }
  snippets: any[]
}

export default interface Page {
  type: string
  language: string
  data: Data
}
