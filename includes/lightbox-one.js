/**
* @property {HTMLElement} element
* @property {string[]} images links to lightbox images
* @property {string} url image displayed
*/

class LightboxOne{
  static init () {
    //use data-full-url instead of src
    //.querySelector('.wp-block-gallery')
    const links = Array.from(document.querySelector('body').querySelectorAll('img[src$=".png"].lightbox-one, img[src$=".jpg"].lightbox-one, img[src$=".jpeg"].lightbox-one'))
      const gallery = links.map(link => link.getAttribute('src'))
      links.forEach(link => link.addEventListener('click', e => {
        e.preventDefault()
        new LightboxOne(e.currentTarget.getAttribute('src'), gallery)
      }))
  }

  /**
  *
  * @param {string} url URL of the picture
  * @param {string[]} images links to lightbox images
  */
  constructor (url, images) {
    this.element = this.buildDOM(url)
    this.loadImage(url)
    this.images = images
    this.onKeyUp = this.onKeyUp.bind(this)
    document.body.appendChild(this.element)
    document.addEventListener('keyup', this.onKeyUp)
  }
  /**
  *
  * @param {string} url URL of the picture
  */
  loadImage (url) {
    this.url = null
    const image = new Image()
    const container = this.element.querySelector('.lightbox__container')
    const loader = document.createElement('div')
    loader.classList.add('lightbox__loader')
    container.innerHTML = ''
    container.appendChild(loader)
    image.onload = () => {
      container.removeChild(loader)
      container.appendChild(image)
      this.url = url
    }
    image.src = url
  }
  /**
  *
  * @param {KeyboardEvent} e
  */
  onKeyUp (e) {
    if (e.key === 'Escape') {
      this.close(e)
    }
  }
  /**
  * Close the lightbox
  * @param {MouseEvent/KeyboardEvent} e
  */
  close (e) {
    e.preventDefault()
    this.element.classList.add('fadeOut')
    window.setTimeout(() => {
      this.element.parentElement.removeChild(this.element)
    }, 500)
    document.removeEventListener('keyup', this.onKeyUp)
  }
  /**
  *
  * @param {string} url URL of the picture
  * @return {HTMLElement}
  */
  buildDOM (url) {
    const dom = document.createElement('div')
    dom.classList.add('lightbox')
    dom.innerHTML = '<button class="lightbox__close">Close</button><div class="lightbox__container"></div>'
    dom.querySelector('.lightbox__close').addEventListener('click', this.close.bind(this))

    return dom
  }
}


LightboxOne.init()
