import React from 'react';
import ReactDOM from 'react-dom';

class EventList extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      events: []
    }
  }

  componentDidMount() {
    fetch('/events/fetch').
      then(response => response.json()).
      then(json => {
        this.setState({
          events: json.events
        });
      });
  }

  render() {
    const events = this.state.events;
    const listEvents = events.map((event) => <li key={event.name}>{event.name}</li>);

    return <ol className="list--events">{listEvents}</ol>;
  }
}

ReactDOM.render(
  <EventList />,
  document.getElementById('EventList')
)