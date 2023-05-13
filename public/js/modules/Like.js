
export default class Like {

    /**
     * @param {HTMLElement|null} likeElements 
     */
      constructor(likeElements){
        this.likeElements = likeElements;

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
            'X-Requested-With': 'XMLHttpRequest'
            },
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
                  span.innerHTML = nb + ' pensées envoyées'
                }else{
                  span.innerHTML = nb + ' patounes'
                }
                // Reste à catch les exceptions
            }).catch(e => alert(e));
      }

  }