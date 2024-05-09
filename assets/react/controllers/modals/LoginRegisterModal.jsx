import { Modal } from "flowbite-react";
import React, { useState } from "react";
import Login from "../forms/Login";
import Register from "../forms/Register";

export default function LoginRegisterModal({openModal, setOpenModal, setUserId}) {
  const [showRegister, setShowRegister] = useState(false);

  return (
    <>
      <Modal className="[&>div>div]:bg-beige" dismissible show={openModal} size="md" popup onClose={() => setOpenModal(false)}>
        <Modal.Header />
          <Modal.Body>
            {showRegister != true ? (
              <Login setShowRegister={setShowRegister} setOpenModal={setOpenModal} setUserId={setUserId}/>
            ) : (
              <Register setShowRegister={setShowRegister} />
            )}
        </Modal.Body>
      </Modal>
    </>
  );
}
