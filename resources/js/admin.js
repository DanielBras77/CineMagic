//dark or light mode
if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
    document.querySelector('html').classList.remove('dark');
    document.querySelector('html').style.colorScheme = 'light';
} else {
    document.querySelector('html').classList.add('dark');
    document.querySelector('html').style.colorScheme = 'dark';
}

document.addEventListener('DOMContentLoaded', () => {
    //sidebar expanded
    if (localStorage.getItem('sidebar-expanded') == 'true') {
        document.querySelector('body').classList.add('sidebar-expanded');
    } else {
        document.querySelector('body').classList.remove('sidebar-expanded');
    }
    
  // Light switcher
  const lightSwitches = document.querySelectorAll('.light-switch');
  if (lightSwitches.length > 0) {
    lightSwitches.forEach((lightSwitch, i) => {
      if (localStorage.getItem('dark-mode') === 'true') {
        lightSwitch.checked = true;
      }
      lightSwitch.addEventListener('change', () => {
        const { checked } = lightSwitch;
        lightSwitches.forEach((el, n) => {
          if (n !== i) {
            el.checked = checked;
          }
        });
        document.documentElement.classList.add('[&_*]:!transition-none');
        if (lightSwitch.checked) {
          document.documentElement.classList.add('dark');
          document.querySelector('html').style.colorScheme = 'dark';
          localStorage.setItem('dark-mode', true);
          document.dispatchEvent(new CustomEvent('darkMode', { detail: { mode: 'on' } }));
        } else {
          document.documentElement.classList.remove('dark');
          document.querySelector('html').style.colorScheme = 'light';
          localStorage.setItem('dark-mode', false);
          document.dispatchEvent(new CustomEvent('darkMode', { detail: { mode: 'off' } }));
        }
        setTimeout(() => {
          document.documentElement.classList.remove('[&_*]:!transition-none');
        }, 1);
      });
    });
  }});
