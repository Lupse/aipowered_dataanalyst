document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('apiForm');
    const input = document.getElementById('query');
    const resultDiv = document.getElementById('result');
    let modeling = ""; // akan diisi secara dinamis

    // Load file hr.sql secara dinamis
    fetch('modeling.php')
    .then(response => response.text())
    .then(sqlText => {
        modeling = sqlText;
    })
    .catch(err => {
        console.error("Gagal memuat file SQL:", err);
        modeling = "";
    });

    const prompting = 'kamu adalah asisten yang sangat memahami mengenai pengolaan data dan sangat memahami data yang telah saya berikan sebelumnya. hanya jawab pertanyaan yang berkorelasi dengan database tersebut, jika ada pertanyaan yang diluar konteks, ucapkan `Maaf, pertanyaan tersebut berada diluar konteks.`.saya adalah orang yang ingin mengolah data tersebut. jika query pertanyaan saya panjang (>30 kata) maka berikan query mysqlnya, tetapi jika query pertanyaan saya dibawah 30 kata maka bantu saya menampilkan hanya hasil dari pertanyaan saya dalam bentuk tabel berformat HTML. gunakan <b> untuk membuat teks menjadi bold. berikut ini adalah pertanyaan saya:';

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const userMsg = input.value.trim();
        if (!userMsg) return;
        
        // Mengubah tampilan loading dengan animasi
        resultDiv.innerHTML = '<div style="text-align: center; padding: 20px;"><span class="loader"></span><p style="margin-top: 15px; color: #666;">Processing your request...</p></div>';

        try {
            const response = await fetch('https://openrouter.ai/api/v1/chat/completions', {
                method: 'POST',
                headers: {
                    // API KEY
                    'Authorization': 'Bearer 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', 
                    'HTTP-Referer': window.location.origin,
                    'X-Title': 'teoribima',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    // Model yang digunakan
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

    // Add event listener for textarea
    input.addEventListener('keydown', function(e) {
        // Check if Enter was pressed without Shift key
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault(); // Prevent default new line
            form.dispatchEvent(new Event('submit')); // Trigger form submission
        }
    });
});