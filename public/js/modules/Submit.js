/**
 * @property {HTMLElement} content
 * @property {HTMLFormElement} form
 */
export default class Submit {

    /**
     * @param {HTMLElement|null} element 
     */
      constructor(element){
          if(element == null){
            return  
          }
          this.content = element.querySelector('.js-auto-refresh-content')     
          this.form = element.querySelector('.js-submit-form')
          this.bindEvents()
      }
      
  
      bindEvents(){
     
        this.form.addEventListener('submit', e => {
            e.preventDefault();
            CKEDITOR.instances.condoleance_texte.updateElement();
          // CKEDITOR.replace('condoleance_texte')
          const textareaValue = CKEDITOR.instances.condoleance_texte.getData();

            const data = new FormData(this.form)
            data.append('condoleance_texte',textareaValue)

            // On crée une nouvelle URL à partir de l'url courante
            const url = new URL(window.location.href) 
            const params = new URLSearchParams()   

            data.forEach((value, key) => {
              console.log(key,value)
                params.append(key, value)          
            })

            fetch(url.pathname + '?' + params.toString(), {
                headers: {
                  //  Permet de différencier une requête classique d'une requête AJAX
                  'X-Requested-With': 'XMLHttpRequest',

                },
                // data : data,
                body: data,
                method: 'POST',
            })
            // .then(response => response.json())
            // Lorsque la promesse provenant de .json aboutit, on récupère ce qui a été traité par le JSON
            .then(async (response) => {
             console.log(response)
              const data = await response.json();
              this.content.innerHTML = data.content
              CKEDITOR.instances.condoleance_texte.setData("")
              console.log(data) 
            })
            .catch(e => alert(e));
        })
      }
  
  }    
  