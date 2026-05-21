import {v4} from 'uuid'

export async function bddMigration(filePath: string) {

  try {
    const file = Bun.file(filePath)
    const content = await file.text()

    const newContentString = createListOfFileStringContentFromOldListOfFileStructure(content)

    if( !newContentString ) {
      console.info('ℹ️ fichier non changé: ', filePath)
    } else {
      console.info('✅ fichier changé !: ', filePath)
      Bun.write(filePath, content + '\n\n----\n\n' + newContentString + '\n\n')
    }

  } catch (error) {
    console.error(`❌ Erreur sur le fichier ${filePath}:`, error)
  }

}

export function createListOfFileStringContentFromOldListOfFileStructure(content: string) {
  const listOfDetails = getListOfDetailsString(content)

  if( !listOfDetails.match ) return null

  const convertedListOfDetails = convertListOfDetailsToArray(listOfDetails.matchValue)
  const stringListOfDetails = JSON.stringify(convertedListOfDetails)

  return `Page-content: [{"content":{"listofdetails":${stringListOfDetails}},"id":"${v4()}","isHidden":false,"type":"array-list"}]`

}

export function getListOfDetailsString(content: string) {
  const match = content.match(/Listofdetails:\s*([\s\S]*?)\n----/)

  return {
    matchValue: match && match[0] ? match[0] : '',
    match: match && match[0],
  }
}

export function convertListOfDetailsToArray(listOfDetails: string) {
  return [...listOfDetails.matchAll(/-\s*name:\s*'(.+?)'\s*value:\s*'(.+?)'/g)]
    .map(match => ({
    name: match[1],
    value: match[2]
  }));

}


