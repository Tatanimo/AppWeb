import React, {useState, useEffect} from 'react'

export default function EditableField({value, size}) {
    const [classSize, setClassSize] = useState("");

    useEffect(() => {
        switch (size) {
            case 1:
                setClassSize("text-xl font-bold font-ChunkFive");
                break;
            case 2: 
                setClassSize("text-lg font-semibold");
                break;
            case 3:
                setClassSize("text-base font-medium");
                break;
        }
    }, []);

  return (
    <>
        <p className={classSize}>{value}</p>
        <button type="button" className='border-solid border-black border-x border-y rounded-full p-2'>
            <img src="img/icons/paint-brush.svg" alt="paint-brush" className='w-4'/>
        </button>
    </>
  )
}
