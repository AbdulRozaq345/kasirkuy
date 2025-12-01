  
const THEME_KEY = "theme"

function toggleDarkTheme() {
  setTheme(
    document.documentElement.getAttribute("data-bs-theme") === 'dark'
      ? "light"
      : "dark"
  )
}

/**
 * Set theme for mazer
 * @param {"dark"|"light"} theme
 * @param {boolean} persist 
 */
function setTheme(theme, persist = false) {
  // Remove both classes first to avoid conflicts
  document.body.classList.remove('dark', 'light')
  
  // Add the desired theme class
  document.body.classList.add(theme)
  document.documentElement.setAttribute('data-bs-theme', theme)
  
  if (persist) {
    localStorage.setItem(THEME_KEY, theme)
  }
}

/**
 * Init theme from setTheme()
 */
function initTheme() {
  //If the user manually set a theme, we'll load that
  const storedTheme = localStorage.getItem(THEME_KEY)
  if (storedTheme) {
    return setTheme(storedTheme)
  }
  
  // Default to light mode (disable auto dark mode detection)
  return setTheme('light', true)
}

window.addEventListener('DOMContentLoaded', () => {
  const toggler = document.getElementById("toggle-dark")
  const theme = localStorage.getItem(THEME_KEY)

  if(toggler) {
    toggler.checked = theme === "dark"
    
    toggler.addEventListener("input", (e) => {
      setTheme(e.target.checked ? "dark" : "light", true)
    })
  }

});

// Handle Livewire navigation - reinitialize theme after page change
if (typeof window.Livewire !== 'undefined') {
  document.addEventListener('livewire:navigated', () => {
    initTheme()
    
    // Re-attach toggle listener after navigation
    const toggler = document.getElementById("toggle-dark")
    const theme = localStorage.getItem(THEME_KEY)
    
    if(toggler) {
      toggler.checked = theme === "dark"
      
      toggler.addEventListener("input", (e) => {
        setTheme(e.target.checked ? "dark" : "light", true)
      })
    }
  })
}

initTheme()

