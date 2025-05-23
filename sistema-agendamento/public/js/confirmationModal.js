 //Obter os elementos HTML que serão manipulados
 const confirmationModal = document.getElementById('confirmationModal');
 const form = document.getElementById('delete_place_form')

 //Escuta o evento de abertura do modal
 confirmationModal.addEventListener('shown.bs.modal', (event) =>{

     //Obter o atributo de dados personalizado
     const id = event.relatedTarget.getAttribute('data-place-id')
     
     //altera o atributo action do form
     form.action = `/places/${id}`
 })