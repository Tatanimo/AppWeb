import React, { useEffect, useState } from 'react'

export default function Alerts({type, flash, fix}) {
    const [color, setColor] = useState('');
    const [bounce, setBounce] = useState('animatecss-bounceInLeft');
    const [disable, setDisable] = useState(false);
    
    useEffect(() => {
        switch (type) {
            case 'success':
                setColor('green');
                break;
            case 'fail':
                setColor('red');
                break;
            case 'info':
                setColor('blue');
                break;
            default:
                setColor('gray');
                break;
        }

        if (!fix) {
            setTimeout(() => {
                setBounce('animatecss-bounceOutLeft');
            }, 3000)
        }
    }, []);

    useEffect(() => {
        if (bounce === "animatecss-bounceOutLeft") {
            setTimeout(() => {
                setDisable(true);
            }, 250)
        }
    }, [bounce])
    
  return (
    <>
        {disable ? null : (
            <div className={`bg-${color}-100 border-l-4 border-${color}-500 text-${color}-700 p-4 w-fit m-4 ${fix ? null : 'animatecss ' + bounce}`} role="alert">
                <p className="font-bold">{flash[0].title}</p>
                <p>{ flash[0].message }</p>
            </div>
        )}
    </>
  )
}
