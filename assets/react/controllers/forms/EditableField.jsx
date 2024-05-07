import React, {useState, useEffect} from 'react'
import 'react-phone-number-input/style.css'
import PhoneInput from 'react-phone-number-input'
import axios from 'axios';

function generateDateRegex() {
    const today = new Date();
    const minDate = new Date(today);
    minDate.setFullYear(minDate.getFullYear() - 100); // 100 ans avant aujourd'hui
    const maxDate = new Date(today);
    maxDate.setFullYear(maxDate.getFullYear() - 15); // 15 ans avant aujourd'hui

    const minYear = minDate.getFullYear();
    const maxYear = maxDate.getFullYear();

    const regexString = `^(${minYear}|19[0-9][0-9]|20(?:0[0-9]|1[0-9]|${maxYear}))(?:-(?:0[1-9]|1[0-2]))-(?:0[1-9]|[12][0-9]|3[01])$`;
    return new RegExp(regexString);
}

export default function EditableField({originalValue, size, type, input, id}) {
    const [classSize, setClassSize] = useState("");
    const [isUpdating, setIsUpdating] = useState(false);
    const [value, setValue] = useState(input == "date" ? originalValue?.date : originalValue);
    const [newValue, setNewValue] = useState({});
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

    const handleValue = () => {
        if (newValue.value != "" && newValue.value && newValue.value != value) {
            let isValid = true;
            switch (newValue.type) {
                case "lastname":
                case "firstname":
                    if (newValue.value.length < 3) {
                        isValid = false;
                        break;
                    }
                    if (newValue.value.length > 30) {
                        isValid = false;
                        break;
                    }
                    break;
                case "email":
                    const emailRegex = new RegExp(/^[A-Za-z0-9_!#$%&'*+\/=?`{|}~^.-]+@[A-Za-z0-9.-]+$/, "gm");
                    if (!emailRegex.test(newValue.value)) {
                        isValid = false;
                        break;
                    }
                    if (newValue.value.length < 6) {
                        isValid = false;
                        break;
                    }
                    if (newValue.value.length > 254) {
                        isValid = false;
                        break;
                    }
                    break;
                case "date":
                    const dateRegex = generateDateRegex();
                    if (!dateRegex.test(newValue.value)) {
                        isValid = false;
                        break;
                    }
                    break;
                case "phone":
                    const e164Regex = new RegExp(/^\+[1-9]\d{1,14}$/);
                    if (!e164Regex.test(newValue.value)) {
                       isValid = false;
                       break; 
                    }
                    break;
            }
            if (isValid) {
                saveInput();
            }
        } else {
            setIsUpdating(false);
            setNewValue({});
        }
    }

    const saveInput = async () => {
        await axios.post(`/ajax/profile/${id}`, newValue, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => setValue(newValue.value))
        .catch(e => console.error(e));

        setIsUpdating(false);
        setNewValue({});
    }

    return(
        <>
            {isUpdating ? (
                <>
                    {input != "phone" ? (
                        <input 
                        autoFocus={true}
                        type={input} 
                        onChange={(e) => setNewValue({value: e.target.value, type: type ? type : input})} 
                        placeholder={value} 
                        className={classSize} 
                        onKeyDown={(e) => e.key == "Enter" ? handleValue() : null} />
                    ) : (
                        <PhoneInput 
                        autoFocus={true}
                        limitMaxLength={true} 
                        defaultCountry="FR" 
                        placeholder="Enter phone number"
                        onKeyDown={(e) => e.key == "Enter" ? handleValue() : null}
                        onChange={(e) => {
                            e != undefined ?
                            setNewValue({value: e, type: type ? type : input}) : setNewValue({})
                        }} 
                        className={classSize} />
                    )}
                    <button onClick={() => handleValue()} type="button" className='border-solid border-black border-x border-y rounded-full p-2 transition-all hover:opacity-70 active:scale-75'>
                        <img src={newValue.value && newValue.value != "" ? "/img/icons/save.svg" : "/img/icons/xmark.svg"} alt="paint-brush" className='w-4 h-4'/>
                    </button>
                </>
                ) : (
                <>
                    <p className={classSize}>{input == "date" ? ( value ? new Date(value).toLocaleDateString() : "Entrer une date de naissance") : value}</p>
                    <button onClick={() => setIsUpdating(true)} type="button" className='border-solid border-black border-x border-y rounded-full p-2 transition-all hover:opacity-70 active:scale-75'>
                        <img src="/img/icons/paint-brush.svg" alt="paint-brush" className='w-4'/>
                    </button>
                </>
            )}
        </>
    )

}
