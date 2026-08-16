import { readdir } from "node:fs/promises"
import path from "node:path"
import { bddMigration } from "./bddMigration"

/**
 * Configuration
 */
const TARGET_DIRECTORY = "./content/3_projets" // Remplacez par le chemin de votre dossier
const SEARCH_STRING = "Template: image"
const SEARCH_STRING_VIDEO = "Template: video"

/**
 * Fonction récursive pour parcourir les dossiers
 */
async function processDirectory(directory: string) {
  try {
    // Lecture du contenu du dossier
    const entries = await readdir(directory, { withFileTypes: true })

    for (const entry of entries) {
      const fullPath = path.join(directory, entry.name)

      if (entry.isDirectory()) {
        // Si c'est un dossier, on appelle la fonction récursivement
        await processDirectory(fullPath)
      } else if (entry.isFile()) {

        if(entry.name.endsWith('.jpg.txt') || entry.name.endsWith('.jpeg.txt') ) {
          // Si c'est un fichier et qu'il finit par .jpg.txt
          await addTemplateImageFile(fullPath)
        } else if(entry.name.endsWith('.mp4.txt') ) {
          // Si c'est un fichier et qu'il finit par .mp4.txt
          await addTemplateVideoFile(fullPath)
        } else {
          await bddMigration(fullPath)
        }

      }
    }
  } catch (error) {
    console.error(`Erreur lors de la lecture du dossier ${directory}:`, error)
  }
}

async function addTemplateImageFile(filePath: string) {
  try {
    const file = Bun.file(filePath)
    const content = await file.text()

    await addTemplateImageForJPGImage(content, filePath)

  } catch (error) {
    console.error(`❌ Erreur sur le fichier ${filePath}:`, error)
  }
}

async function addTemplateImageForJPGImage(content: string, filePath: string) {
  // Vérifie si la chaîne existe déjà dans le contenu
  if (!content.includes(SEARCH_STRING)) {
    // On ajoute la chaîne à la fin (avec un saut de ligne pour la propreté)
    const newContent = content.endsWith("\n")
      ? `${content}----\n${SEARCH_STRING}`
      : `${content}\n----\n${SEARCH_STRING}`

    await Bun.write(filePath, newContent)
    console.log(`✅ Template image Modifié : ${filePath}`)
  } else {
    console.log(`ℹ️  Template image Déjà présent : ${filePath}`)
  }
}

async function addTemplateVideoFile(filePath: string) {
  try {
    const file = Bun.file(filePath)
    const content = await file.text()

    await addTemplateVideoForMP4Video(content, filePath)

  } catch (error) {
    console.error(`❌ Erreur sur le fichier ${filePath}:`, error)
  }
}

async function addTemplateVideoForMP4Video(content: string, filePath: string) {
  // Vérifie si la chaîne existe déjà dans le contenu
  if (!content.includes(SEARCH_STRING_VIDEO)) {
    // On ajoute la chaîne à la fin (avec un saut de ligne pour la propreté)
    const newContent = content.endsWith("\n")
      ? `${content}----\n${SEARCH_STRING_VIDEO}`
      : `${content}\n----\n${SEARCH_STRING_VIDEO}`

    await Bun.write(filePath, newContent)
    console.log(`✅ Template video Modifié : ${filePath}`)
  } else {
    console.log(`ℹ️  Template video Déjà présent : ${filePath}`)
  }
}

// Lancement du script
console.log(`🚀 Début du scan dans : ${path.resolve(TARGET_DIRECTORY)}`)
processDirectory(TARGET_DIRECTORY).then(() => {
  console.log("✨ Terminé !")
})
