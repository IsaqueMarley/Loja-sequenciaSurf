document.addEventListener('DOMContentLoaded', function () {
    // DADOS DA API
    const apiKey = 'ddbd203708152d15841ff81cb09cadec';
    const city = 'Aracaju';
    const apiUrl = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${apiKey}&units=metric&lang=pt_br`;

    function getWeatherData() {
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                const weatherInfo = document.getElementById('weather-info');

                // Informações atuais
                const currentWeather = data.list[0];
                const currentTemperature = currentWeather.main.temp;
                const currentDescription = currentWeather.weather[0].description;
                const currentIcon = currentWeather.weather[0].icon;
                const currentWindSpeed = currentWeather.wind.speed;
                const currentWindDirection = currentWeather.wind.deg;
                const currentDate = new Date();

                // EXIBIR INFORMAÇÕES DO DIA ATUAL
                weatherInfo.innerHTML = `
                <div class="forecast-day current-day">
                    <h2>Atual</h2>
                    <p>Data: ${formatDate(currentDate)}</p>
                    <img src="http://openweathermap.org/img/wn/${currentIcon}.png" alt="Weather Icon">
                    <p>${currentDescription}</p>
                    <p>Temperatura: ${currentTemperature}°C</p>
                    <p>Velocidade do Vento: ${currentWindSpeed} m/s</p>
                    <p>Direção do Vento: ${getWindDirection(currentWindDirection)}</p>
                </div>
                `;

                // PREVISÃO PARA MAIS 4 DIAS
                const forecast = data.list.filter(item => item.dt_txt.includes('12:00:00'));

                // ALTERAR O NÚMERO DE DIAS QUE DESEJA EXIBIR
                const numberOfDaysToShow = 4;

                // REMOVER O ÚLTIMO DIA DE PREVISÃO
                if (forecast.length > numberOfDaysToShow) {
                    forecast.pop();
                }

                forecast.forEach(day => {
                    const date = new Date(day.dt * 1000); 
                    const dayOfWeek = getDayOfWeek(date.getDay());
                    const formattedDate = formatDate(date);
                    const temperature = day.main.temp;
                    const description = day.weather[0].description;
                    const icon = day.weather[0].icon;
                    const windSpeed = day.wind.speed;
                    const windDirection = day.wind.deg;

                    // ADICIONAR INFORMAÇÕES DA PREVISÃO AO CONTEÚDO EXISTENTE
                    weatherInfo.innerHTML += `
                    <div class="forecast-day">
                        <h2>${dayOfWeek}</h2>
                        <p>${formattedDate}</p>
                        <img src="http://openweathermap.org/img/wn/${icon}.png" alt="Weather Icon">
                        <p>${description}</p>
                        <p>Temperatura: ${temperature}°C</p>
                        <p>Velocidade do Vento: ${windSpeed} m/s</p>
                        <p>Direção do Vento: ${getWindDirection(windDirection)}</p>
                    </div>
                `;
                });
            })
            .catch(error => {
                console.error('Erro ao obter dados da API:', error);
                const weatherInfo = document.getElementById('weather-info');
                weatherInfo.innerHTML = 'Erro ao obter dados da API';
            });
    }

    // FUNÇÃO PARA CONVERTER A DIREÇÃO DO VENTO EM GRAUS PARA UM PONTO CARDINAL
    function getWindDirection(degrees) {
        const directions = ['N', 'NE', 'L', 'SE', 'S', 'SO', 'O', 'NO'];
        const index = Math.round(degrees / 45) % 8;
        return directions[index];
    }

    function getDayOfWeek(dayIndex) {
        const daysOfWeek = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
        return daysOfWeek[dayIndex];
    }

    function formatDate(date) {
        const options = { year: 'numeric', month: 'numeric', day: 'numeric' };
        return date.toLocaleDateString('pt-BR', options);
    }

    getWeatherData();

    /* ATUALIZAR AS INFORMAÇÕES A CADA HORA */
    setInterval(getWeatherData, 3600000)
});