document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('apiForm');
    const input = document.getElementById('queryInput'); // Update selector
    const resultDiv = document.getElementById('result');
    const outputTypeRadios = document.getElementsByName('outputType');
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

    const getPromptting = (outputType) => {
        if (outputType === 'hasil') {
            return 'kamu adalah asisten yang sangat memahami mengenai pengolaan data dan sangat memahami data yang telah saya berikan sebelumnya. hanya jawab pertanyaan yang berkorelasi dengan database tersebut, jika ada pertanyaan yang diluar konteks, ucapkan `Maaf, pertanyaan tersebut berada diluar konteks.`. saya adalah orang yang ingin mengolah data tersebut. tampilkan hasil dari pertanyaan saya dalam bentuk tabel berformat HTML. gunakan <b> untuk membuat teks menjadi bold. berikut ini adalah pertanyaan saya:';
        } else {
            return 'kamu adalah asisten yang sangat memahami mengenai pengolaan data dan sangat memahami data yang telah saya berikan sebelumnya. hanya jawab pertanyaan yang berkorelasi dengan database tersebut, jika ada pertanyaan yang diluar konteks, ucapkan `Maaf, pertanyaan tersebut berada diluar konteks.`. saya adalah orang yang ingin mengolah data tersebut. berikan query MySQL untuk menjawab pertanyaan saya. berikut ini adalah pertanyaan saya:';
        }
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const userMsg = input.value.trim(); 
        if (!userMsg) return;
        
        // Get selected output type
        const selectedOutputType = Array.from(outputTypeRadios).find(radio => radio.checked).value;
        const prompting = getPromptting(selectedOutputType); // Perbaiki typo dari getPromptting menjadi getPrompting
        
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