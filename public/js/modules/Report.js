import Delete from './Delete.js'

export default class Report {

    /**
     * @param {HTMLElement|null} reportElements 
     */
      constructor(reportElements){
        this.reportElements = reportElements;

          if(reportElements){
            this.init()
          }
      }
  
      init(){
        //  On enlève la logique de base 
        this.reportElements.map(element => {
            element.addEventListener('click', this.onClick)
        }) 
      }

      onClick(event){
        
        event.preventDefault();
        const url = new URL(this.href|| window.location.href);
        // Avant la promesse, on sélectionne l'icone actuelle
        console.log(this)
        const icone = this.querySelector('.flag-report-icon');      
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
              if(icone.classList.contains('unreported')){
                console.log("je reporte")
                icone.classList.replace('unreported','reported')
              }else{
                console.log("je ne veux plus reporter")
                 icone.classList.replace('reported','unreported')
              }

                const deleteElements = [].slice.call(document.querySelectorAll('.delete'));
                if(deleteElements){
                    new Delete(deleteElements);
                }

                console.log(response)
                // Reste à catch les exceptions
            }).catch(e => alert(e));
      }

  }