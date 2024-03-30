/* BARRA DE NAVEGAÇÃO RESPONSIVA */
/* RESPONSIVIDADE DO MENU LATERAL */
document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.querySelector(".menu-toggle");
  const sidebar = document.querySelector(".sidebar");
  const menuIcon = document.querySelector("#menuIcon");
  const closeIcon = document.querySelector("#closeIcon");

  menuToggle.addEventListener("click", function () {
    sidebar.classList.toggle("show");
    menuIcon.style.display = sidebar.classList.contains("show") ? "none" : "block";
    closeIcon.style.display = sidebar.classList.contains("show") ? "block" : "none";
  });
});

/* SCRIPTS */
fetch("dados.json")
  .then((response) => response.json())
  .then((data) => {
    const today = new Date();
    const tableBody = document.querySelector("#resultado");

    for (let i = 0; i < 5; i++) {
      const currentDate = new Date(today);
      currentDate.setDate(today.getDate() + i);

      const formattedDate = formatDate(currentDate);

      const matchingRow = data.find((item) => item.datas === formattedDate);

      if (matchingRow) {
        const row = document.createElement("tr");

        const dataCell = document.createElement("td");
        dataCell.textContent = matchingRow.datas;
        row.appendChild(dataCell);

        matchingRow.mares.forEach((mare) => {
          const mareCell = document.createElement("td");

          // Divide a string da maré em horário e altura
          const [horario, altura] = mare.split(' ');

          // Cria elementos para o horário e a altura
          const horarioElement = document.createElement("div");
          horarioElement.textContent = horario;

          const alturaElement = document.createElement("div");
          alturaElement.textContent = altura;

          // Adiciona os elementos ao td
          mareCell.appendChild(horarioElement);
          mareCell.appendChild(alturaElement);

          row.appendChild(mareCell);
        });

        tableBody.appendChild(row);
      } else {
        console.error("Data não encontrada para " + formattedDate);
      }
    }
  })
  .catch((error) => {
    console.error("Erro ao carregar o arquivo JSON: " + error);
  });

function formatDate(date) {
  const dd = String(date.getDate()).padStart(2, "0");
  const mm = String(date.getMonth() + 1).padStart(2, "0");
  const yyyy = date.getFullYear();
  return dd + "/" + mm + "/" + yyyy;
}

/* CONTATOS INTERATIVOS */
const contatos = document.getElementById('contatos');
const footer = document.getElementById('footer');

contatos.addEventListener('click', () => {
  footer.scrollIntoView({ behavior: 'smooth' });
});

/* CONTATOS INTERATIVOS NA RESPOSIVIDADE */
const contatosResp = document.getElementById('contatos-resp');

contatosResp.addEventListener("click", function () {
  footer.scrollIntoView({ behavior: 'smooth' }); // ROLA A PÁGINA ATÉ O FOOTER
  // FECHA O MENU LATERAL QUANDO CARREGA ATÉ O FOOTER
  sidebar.classList.toggle("show");
  menuIcon.style.display = sidebar.classList.contains("show") ? "none" : "block";
  closeIcon.style.display = sidebar.classList.contains("show") ? "block" : "none";
});

/* API DE PREVISÃO DO TEMPO */
const apiKey = "ddbd203708152d15841ff81cb09cadec";

