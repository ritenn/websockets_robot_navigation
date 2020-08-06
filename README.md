## Arduino websocket navigation system

This application was built with Laravel & VUE to controll 4W robot based on Arduino microcontroller via ESP8266 and websockets. However main goal is to test what I can do with generally available sensors and if I can create indoor navigation system for further projects.

Features so far:
- Robot configuration managment
- Automatically checking online status & reconnects if necessary
- Manual navigation via websockets
- Console to communicate with robot

Work in progress:
- Scheduled/live navigation system based on waypoints
- Adding more features to console
- Recording manual navigation commands and store for reuse (list of waypoints to replay)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
