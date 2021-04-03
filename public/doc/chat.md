# Chat

how does chat work?

what are the back-end endpoints and service parameters?

## chat message

A chat message body is JSON format. It consists of a header and an array of messages.

```json
{
    "header": {
        "version": "1.0.1",
        "timestamp": 1490303898
    },
    "messages": [
        {
            "header": {
                "app": "none",
                "channel": "a",
                "from": {
                    "name": "Herman Munster",
                    "id": 10277
                },
                "timestamp": 1490303898,
                "auth": "",
                "ttl": 0
            },
            "payload": {
                "event": "message",
                "subject": "",
                "message": ""
            }
        },
        {
            "header": {
                "app": "none",
                "channel": "a",
                "from": {
                    "name": "Herman Munster",
                    "id": 10277
                },
                "timestamp": 1490303898,
                "auth": "",
                "ttl": 0
            },
            "payload": {
                "event": "join",
                "subject": "",
                "message": ""
            }
        },
        {
            "header": {
                "app": "none",
                "channel": "a",
                "from": {
                    "name": "Herman Munster",
                    "id": 10277
                },
                "timestamp": 1490303898,
                "auth": "",
                "ttl": 0
            },
            "payload": {
                "event": "leave"
            }
        }
    ]
}
```
