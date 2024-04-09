import React, {useEffect, useState} from 'react'
import Alerts from './Alerts';

export default function Mercure() {
    const [alerts, setAlerts] = useState([]);
    
    useEffect(() => {
        const url = JSON.parse(document.getElementById("mercure-notification").textContent);
        const eventSource = new EventSource(url);
        eventSource.onmessage = event => {
            console.log(event.data);
            setAlerts(prevAlerts => [...prevAlerts, JSON.parse(event.data)]);
        }
    }, [])
    
    if (alerts.length > 0) {
        return (
          <>
              {alerts.map((e, index) => {
                return(
                    <Alerts key={index} type={e.type} flash={e.flash}/>
                )
              })}
          </>
        )
    }
}
