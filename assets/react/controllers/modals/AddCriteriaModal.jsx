import { Button, Label, Modal, Spinner, TextInput } from 'flowbite-react';
import React, { useState } from 'react'
import axios from 'axios';
import Requirement from '../alerts/Requirement';
import { endpoint } from '../../../config';
import { ReactSVG } from 'react-svg'

const emojis = ["ban", "cat", "dog", "couch", "house", "appartment", "non-smoker", "smoker", "timer"];

function AddCriteriaModal({openModal, setOpenModal, professionalId, setCriterias}) {
    const [loading, setLoading] = useState(false);
    const [requirements, setRequirements] = useState([]);
    const [criteria, setCriteria] = useState({});

    const handleSubmit = async () => {
        if (handleForm() == true) {
            setLoading(true);
            axios.post(`/ajax/professional/criteria/${professionalId}`, criteria, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                setOpenModal(false);
                setCriterias(res.data.criteria);
            })
            .catch(err => console.error(err))
            .finally(() => setLoading(false));
        }   
    }

    const handleForm = () => {
        let arrayRequirements = [];

        if (criteria == null) {
            arrayRequirements.push("Critère invalide.");
        }

        if (criteria.emoji == null || criteria.emoji == "") {
            arrayRequirements.push("Vous devez sélectionner un emoji.");
        }

        if (criteria.content.length <= 3) {
            arrayRequirements.push("Le contenu du critère doit contenir 3 caractères au minimum.");
        }

        if (criteria.content.length > 50) {
            arrayRequirements.push("Le contenu du critère doit contenir 50 caractères au maximum.");
        }

        if (arrayRequirements.length > 0) {
            setRequirements(arrayRequirements);
            return false;
        }
        else {
            setRequirements([]);
            return true;
        }
    }

  return (
    <Modal className="" dismissible show={openModal} size="md" popup onClose={() => setOpenModal(false)}>
        <Modal.Header>
         Ajouter un critère
        </Modal.Header>
        <Modal.Body>
            <div className="space-y-6 ">
                {requirements.length > 0 ? (<Requirement requirements={requirements} />) : null}
                <div className="mb-2 block">
                    <Label value="Choisir l'emoji du critère:" />
                </div>
                <div className="grid grid-cols-5 grid-rows-1 gap-3 !mt-0">
                    {emojis.map((e, i) => {
                        return(
                            <button key={i} type='button' onClick={() => setCriteria({...criteria, emoji: e})} className={`content-center transition-all hover:opacity-70 w-fit active:scale-75 p-1`}>
                                <ReactSVG src={`${endpoint.img}/emojis/${e}.svg`} className={`w-8 ${criteria.emoji == e ? "fill-blue-purple" : null}`}/>
                            </button>
                        )
                    })}
                </div>
                <div className="mb-2 block">
                    <Label value="Écrivez du contenu:" />
                </div>
                <TextInput maxLength={50} onChange={el => setCriteria({...criteria, content: el.target.value})} required className='!mt-0'/>
                <div className="w-full flex justify-center">
                    {loading ? (
                    <Spinner className="m-auto h-10 w-10 text-blue-purple"/>
                    ) : (
                    <Button className="m-auto bg-blue-purple w-64 hover:opacity-75 hover:!bg-blue-purple" onClick={() => handleSubmit()}>Ajouter un critère</Button>
                    )}
                </div>
            </div>
        </Modal.Body>
    </Modal>
  )
}

export default AddCriteriaModal