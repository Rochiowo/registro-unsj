document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('animalSearch');
    const sortAnimals = document.getElementById('sortAnimals');
    const tableBody = document.querySelector('#animalsTable tbody');
    const empty = document.getElementById('animalSearchEmpty');
    const count = document.querySelector('.animals-page .results-count');
    const pageButtons = document.getElementById('animalPageButtons');
    const pageArrows = document.querySelectorAll('[data-animal-page-direction]');
    const perPage = document.getElementById('animalPerPage');
    let animalRows = Array.from(document.querySelectorAll('#animalsTable .animal-row'));
    let sortAscending = false;
    let currentPage = 1;

    if (!search || !sortAnimals || !tableBody || !empty || !count || !pageButtons || !perPage) return;

    function renderAnimals() {
        const term = search.value.trim().toLowerCase();
        const matchingRows = animalRows.filter(function (row) {
            return row.textContent.toLowerCase().includes(term);
        });
        const pageSize = Number(perPage.value);
        const totalPages = Math.max(1, Math.ceil(matchingRows.length / pageSize));
        currentPage = Math.min(currentPage, totalPages);
        const firstVisible = (currentPage - 1) * pageSize;
        const lastVisible = firstVisible + pageSize;

        animalRows.forEach(function (row) {
            row.style.display = 'none';
        });
        matchingRows.slice(firstVisible, lastVisible).forEach(function (row) {
            row.style.display = '';
        });

        empty.hidden = term === '' || matchingRows.length > 0;
        count.textContent = matchingRows.length === 0
            ? 'Mostrando 0 animales'
            : 'Mostrando ' + (firstVisible + 1) + ' a ' + Math.min(lastVisible, matchingRows.length) + ' de ' + matchingRows.length + ' animales';

        pageButtons.replaceChildren();
        for (let page = 1; page <= totalPages; page++) {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'page-btn' + (page === currentPage ? ' active' : '');
            button.textContent = page;
            button.addEventListener('click', function () {
                currentPage = page;
                renderAnimals();
            });
            pageButtons.appendChild(button);
        }

        pageArrows.forEach(function (arrow) {
            arrow.disabled = arrow.dataset.animalPageDirection === 'previous'
                ? currentPage === 1
                : currentPage === totalPages;
        });
    }

    search.addEventListener('input', renderAnimals);
    perPage.addEventListener('change', function () {
        currentPage = 1;
        renderAnimals();
    });
    sortAnimals.addEventListener('click', function () {
        sortAscending = !sortAscending;
        animalRows.sort(function (firstRow, secondRow) {
            const firstName = firstRow.querySelector('.animal-name-cell').textContent.trim();
            const secondName = secondRow.querySelector('.animal-name-cell').textContent.trim();
            const comparison = firstName.localeCompare(secondName, undefined, { sensitivity: 'base' });

            return sortAscending ? comparison : -comparison;
        });

        animalRows.forEach(function (row) {
            tableBody.appendChild(row);
        });
        sortAnimals.setAttribute('aria-pressed', String(!sortAscending));
        sortAnimals.querySelector('.sort-icon').textContent = sortAscending ? 'A-Z' : 'Z-A';
        currentPage = 1;
        renderAnimals();
    });
    pageArrows.forEach(function (arrow) {
        arrow.addEventListener('click', function () {
            currentPage += arrow.dataset.animalPageDirection === 'previous' ? -1 : 1;
            renderAnimals();
        });
    });

    renderAnimals();
});