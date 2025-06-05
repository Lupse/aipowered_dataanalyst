document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('apiForm');
    const input = document.getElementById('query');
    const resultDiv = document.getElementById('result');
    let modeling = ""; // akan diisi secara dinamis

    // Load file hr.sql secara dinamis
    fetch('hr.sql')
        .then(response => response.text())
        .then(sqlText => {
            modeling = sqlText;
        })
        .catch(err => {
            console.error("Gagal memuat file SQL:", err);
            modeling = "";
        });

    const prompting = 'kamu adalah asisten yang sangat memahami mengenai pengolaan data dan sangat memahami data yang telah saya berikan sebelumnya.saya adalah orang yang ingin mengolah data tersebut. bantu saya menampilkan hanya hasil dari pertanyaan saya dalam bentuk tabel berformat HTML. berikut ini adalah pertanyaan saya:';

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const userMsg = input.value.trim();
        if (!userMsg) return;
        resultDiv.innerHTML = "Loading...";

        try {
            const response = await fetch('https://openrouter.ai/api/v1/chat/completions', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer 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', 
                    'HTTP-Referer': window.location.origin,
                    'X-Title': 'teoribima',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    model: 'deepseek/deepseek-r1-0528:free',
                    messages: [{ role: 'user', content: modeling + "\n" + prompting + "\n" + userMsg }]
                })
            });
            const data = await response.json();
            let botReply = "Maaf, tidak ada balasan.";
            if (data && data.choices && data.choices[0] && data.choices[0].message && data.choices[0].message.content) {
                botReply = data.choices[0].message.content.trim();
            }
            resultDiv.innerHTML = '<pre>' + botReply + '</pre>';
        } catch (error) {
            resultDiv.innerHTML = "Error: " + error.message;
        }
    });
});