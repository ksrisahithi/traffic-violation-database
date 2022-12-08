var script = document.createElement('script');
var script2 = document.createElement('script');
script.type = 'text/javascript';
script2.type = 'text/javascript';

script.src = "https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"; 
script2.src = 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js';

script.integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/";
script2.integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo";

script.crossOrigin="anonymous";
script2.crossOrigin="anonymous";

document.body.appendChild(script2);  
document.body.appendChild(script);