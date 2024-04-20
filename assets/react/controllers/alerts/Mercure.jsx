import React, {useEffect, useState} from 'react'
import Alerts from './Alerts';
import { EventSourcePolyfill } from 'event-source-polyfill';

export default function Mercure() {
    const [alerts, setAlerts] = useState([]);
    
    useEffect(() => {
        const url = JSON.parse(document.getElementById("mercure-notification").textContent);
        const jwtInput = document.getElementById("jwt-notification");
        const jwt = JSON.parse(jwtInput.value.replace(/\s/g, ''));
        jwtInput.remove();
        
        const eventSource = new EventSourcePolyfill(url, { withCredentials: true, 
            headers: {
                'Authorization': `Bearer ${jwt}`
            }
        });
        
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
