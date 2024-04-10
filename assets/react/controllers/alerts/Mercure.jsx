import React, {useEffect, useState} from 'react'
import Alerts from './Alerts';
import { EventSourcePolyfill } from 'event-source-polyfill';

export default function Mercure() {
    const [alerts, setAlerts] = useState([]);
    
    useEffect(() => {
        const url = JSON.parse(document.getElementById("mercure-notification").textContent);
        const jwt = JSON.parse(document.getElementById("jwt-notification").textContent.replace(/\s/g, ''));
        
        const eventSource = new EventSourcePolyfill(url, { withCredentials: true, 
            headers: {
                'Authorization': `Bearer ${jwt}`
            }
        });
        console.log(eventSource);
        
        eventSource.onmessage = event => {
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
