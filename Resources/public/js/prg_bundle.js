window.onload = function () {
    var linksElements = document.querySelectorAll('.prg-link[data-submit]');
    var redirectForm = document.querySelector('#prgform');
    var redirectInput = document.querySelector('#prgdata');

    var submitForm = function (e) {
        e.preventDefault();
        redirectInput.value = this.getAttribute('data-submit');
        redirectForm.setAttribute('target', this.getAttribute('data-target'));
        redirectForm.submit();
    };

    Array.prototype.forEach.call(linksElements, function(linkElement, i){
        linkElement.addEventListener('click', submitForm, false);
    });
};