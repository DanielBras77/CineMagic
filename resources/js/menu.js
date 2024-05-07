(() => {
    let refMenu = null
    let btnHamburger = null
    let openSvgPath = null
    let closeSvgPath = null

    let buttonsSubMenu = null
    let knownSubMenus = []

    const showElement = (element) => {
        element.classList.remove('h-0')
        element.classList.remove('invisible')
        element.classList.add('h-auto')
        element.classList.add('visible')
    }

    const hideElement = (element) => {
        element.classList.remove('h-auto')
        element.classList.remove('visible')
        element.classList.add('h-0')
        element.classList.add('invisible')
    }

    const clickBtnHamburger = () => {
        if (refMenu.classList.contains('invisible')) {
            hideElement(openSvgPath)
            showElement(refMenu)
            showElement(closeSvgPath)
        } else {
            hideElement(closeSvgPath)
            hideElement(refMenu)
            knownSubMenus.forEach((submenu) => {
                hideElement(submenu)
            })
            showElement(openSvgPath)
        }
        btnHamburger.blur()
    }

    const clickBtnSubmenu = (event) => {
        // If the browser's width is equal or larger that 640px, do nothing
        if ((window.innerWidth >= 640) || (!event.currentTarget)) {
            return
        }
        if (event.currentTarget) {
            let subMenu = document.getElementById(event.currentTarget.dataset.submenu ?? '')
            if (subMenu) {
                if (!knownSubMenus.includes(subMenu)) {
                    knownSubMenus.push(subMenu)
                }
                if (subMenu.classList.contains('invisible')) {
                    showElement(subMenu)
                } else {
                    hideElement(subMenu)
                }
            }
            event.currentTarget.blur()
        }
    }


    window.addEventListener("load", (event) => {
        // Initialize DOM elements references
        refMenu = document.getElementById('menu-container')
        btnHamburger = document.getElementById('hamburger_btn')
        openSvgPath = document.getElementById('hamburger_btn_open')
        closeSvgPath = document.getElementById('hamburger_btn_close')

        // Initialize all submenu buttons
        buttonsSubMenu = document.querySelectorAll('[data-submenu]')
        // Initialize all known submenus
        knownSubMenus = []


        // Initialize DOM elements events
        hamburger_btn.addEventListener('click', clickBtnHamburger)
        if (buttonsSubMenu)
            buttonsSubMenu.forEach(element => {
                element.addEventListener('click', clickBtnSubmenu)
        });
    })
})()
