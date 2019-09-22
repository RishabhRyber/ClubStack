window.onload = function () {
    document.querySelector('#events-tab').addEventListener('click', function () {
        document.querySelector('#events-full').style.display = 'block';
        document.querySelector('#recruits-full').style.display = 'none';
        document.querySelector('.tab-0').classList.remove('active');
        document.querySelector('.tab-0').classList.add('active');
        document.querySelector('.tab-1').classList.remove('active');
    });
    document.querySelector('#recruits-tab').addEventListener('click', function () {
        document.querySelector('#recruits-full').style.display = 'block';
        document.querySelector('#events-full').style.display = 'none';
        document.querySelector('.tab-1').classList.remove('active');
        document.querySelector('.tab-0').classList.remove('active');
        document.querySelector('.tab-1').classList.add('active');
    });
    var name = document.getElementById('name').textContent;
    if (name.length >= 8) {
        document.getElementById('name').style.fontSize = "45px";
    }
    document.getElementById('name').addEventListener('mouseover', function () {
        document.getElementById('name').style.color = 'white';
    });
    document.getElementById('name').addEventListener('mouseout', function () {
        document.getElementById('name').style.color = '#003399';
    });
};