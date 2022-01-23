var myModal = document.getElementById('statsBox')
var myInput = document.getElementById('statsButton')

myModal.addEventListener('shown.bs.modal', function () {
    myInput.focus()
})