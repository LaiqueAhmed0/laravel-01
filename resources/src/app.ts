import '@/app.scss';
import Echo from 'laravel-echo';
import PollcastConnector from '@supportpal/pollcast/src/pollcast';

window.Echo = new Echo({
    broadcaster: PollcastConnector,
    csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
    routes: {
        connect: "/pollcast/connect",
        receive: "/pollcast/subscribe/messages",
        publish: "/pollcast/publish",
        subscribe: "/pollcast/channel/subscribe",
        unsubscribe: "/pollcast/channel/unsubscribe"
    },
    polling: 5000
});

window.Echo.connector.connect()
