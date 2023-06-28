import {openDialogToDeleteElements} from './Delete.js'

export default class Like {

    /**
     * @param {HTMLElement|null} likeElements 
     */
      constructor(likeElements){
        this.likeElements = likeElements;
        this.content = document.querySelector('.js-refresh-like');
        var contenu = this.content
        console.log(contenu)

          if(likeElements){
            this.init()
          }
      }
  
      init(){
        //  On enlève la logique de base 
        this.likeElements.map(element => {
            element.addEventListener('click', this.onClick)
        }) 
      }

      onClick(event){
        
        event.preventDefault();
        const url = new URL(this.href|| window.location.href);
        // Avant la promesse, on sélectionne l'icone actuelle
        console.log(this)
        const icone = this.querySelector('i');
        const span = this.querySelector('span');        
        console.log(url)
        fetch(url.pathname + "?", {
            headers: {
              // 'Sec-Fetch-Site': 'same-origin',
            // 'Access-Control-Allow-Origin': '*',
            'X-Requested-With': 'XMLHttpRequest'
            },
            // dataType: "json",
            // mode: 'cors',
            // method: 'GET'
        })
            .then(response => response.json())
            .then(response => {

              // On vérifie dans quel cas on est 
              if(icone.classList.contains('unlikedPaw')){
                console.log("j'aime")
                icone.classList.replace('unlikedPaw','likedPaw')
              }else{
                console.log("je n'aime plus")
                 icone.classList.replace('likedPaw','unlikedPaw')
              }
                // console.log(this)
                const nb = response.nbLike;
                console.log(url)

                this.dataset.nb = nb;
                if(span.classList.contains('pensee')){

                  if(nb > 1){
                    span.innerHTML = nb + ' pensées envoyées'                    
                  }else{
                    span.innerHTML = nb + ' pensée envoyée'                    
                  }

                }else{
                  
                  if(nb > 1){
                    span.innerHTML = nb + ' patounes'
                  }else{
                    span.innerHTML = nb + ' patoune'
                  }

                }


                // const deleteElements = [].slice.call(document.querySelectorAll('.delete'));
                // if(deleteElements){
                //     new Delete(deleteElements);
                // }

                openDialogToDeleteElements()

                console.log(response)
                // Reste à catch les exceptions
            }).catch(e => alert(e));
      }

  }