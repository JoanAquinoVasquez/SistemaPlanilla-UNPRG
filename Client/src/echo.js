import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

const echoInstance = new Echo({
  broadcaster: "reverb",
  key: import.meta.env.VITE_REVERB_APP_KEY,
  wsHost: import.meta.env.VITE_REVERB_HOST,
  wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
  wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
  forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
  enabledTransports: ["ws", "wss"],
  authorizer: (channel) => {
    return {
      authorize: (socketId, callback) => {
        axios
          .post(`${import.meta.env.VITE_BACKEND_URL}/api/broadcasting/auth`, {
            socket_id: socketId,
            channel_name: channel.name,
          })
          .then((response) => callback(false, response.data))
          .catch((error) => callback(true, error));
      },
    };
  },
});

// Exporta la instancia de Echo
export default echoInstance;
