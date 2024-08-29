document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('uid-form');
    const uidInput = document.getElementById('uid-input');
    const tokenField = document.getElementById('token');
    const resultDiv = document.getElementById('result');
    const accessDenyDiv = document.getElementById('access-deny');

    function generateToken() {
        return crypto.getRandomValues(new Uint8Array(16)).toString('hex');
    }

    function setToken() {
        const token = localStorage.getItem('token') || generateToken();
        localStorage.setItem('token', token);
        tokenField.value = token;
    }

    function getApi(uid) {
        const url = `api_proxy.php?uid=${encodeURIComponent(uid)}`;

        return fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.playerInfo) {
                const { playerInfo } = data;
                const playerNickname = playerInfo.nickname;
                const playerLevel = playerInfo.level;
                const playerAvatarId = playerInfo.profilePicture.avatarId;
                return `
                    <p>Player Nickname: ${playerNickname}</p>
                    <p>Player Level: ${playerLevel}</p>
                    <p>Player Avatar ID: ${playerAvatarId}</p>
                    <p>Detail -> <a href="https://enka.network/api/uid/${uid}/" style="color:blue;">https://enka.network/api/uid/${uid}/</a></p>
                `;
            } else {
                throw new Error('Invalid response structure');
            }
        })
        .catch(error => {
            console.error(error);
            resultDiv.innerHTML = 'JSON Error: ' + error.message;
        });
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const uid = uidInput.value;
        const token = tokenField.value;

        if (token === localStorage.getItem('token')) {
            getApi(uid).then(html => {
                resultDiv.innerHTML = html;
            });
        } else {
            accessDenyDiv.style.display = 'block';
        }
    });

    setToken(); // Ensure token is set on page load
});