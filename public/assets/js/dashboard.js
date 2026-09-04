document.querySelectorAll('.resolve-button').forEach(button => {
    button.addEventListener('click', async function () {
        const confirmed = confirm(
            'Tem certeza que deseja resolver este serviço?'
        );

        if (!confirmed) {
            return;
        }

        const serviceId = this.dataset.serviceId;
        const url = this.dataset.serviceUrl;
        // console.log('Botão de resolver clicado');
        // console.log(`ID do serviço: ${serviceId}`);
        // console.log(`URL: ${url}`);

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    serviceId: serviceId
                })
            });

            // console.log('Resposta da requisição:', response);

            const result = await response.json();

            if (!result.success) {
                alert(result.message);
                return;
            }

            window.location.href = result.redirect;
        } catch (error) {
            // console.error(error);
            // alert('Erro ao resolver o serviço.');
        }
    });
});
