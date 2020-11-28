import React, { useState } from 'react';
import { Form, Row, Col, Button } from 'react-bootstrap';
//import axios from 'axios';


function WPForm() {
  const [ state, setState ] = useState({ companyname: "", firstname: "", lastname: "", jobtitle:"", phonenumber: "", email:"", errors: [] });

  const handleInputChange = (event) => {
    const key = event.target.name;
    const value = event.target.value;
    setState( prevState => {
      return { ...prevState, [key]:value }
    })

  }

  const hasError= (key) => {
    return state.errors.indexOf(key) !== -1;
  }

  const handleSubmit = (event) => {

    event.preventDefault();
  
    //VALIDATE
    const errors = [];
  
    //CompanyName
    if (state.companyname === "") {
      errors.push("companyname");
    }
  
    //Phone Number
    if (state.phonenumber === "") {
      errors.push("phonenumber");
    }
  
    //email
    const expression = /\S+@\S+/;
    var validEmail = expression.test(String(state.email).toLowerCase());
  
    if (!validEmail) {
      errors.push("email");
    }
  
    setState({
      errors:errors
    })
    console.log("Error:", errors);
    console.log("State:", state);


    setState( prevState => {
      return { ...prevState, [errors]:errors }
    })
    // console.log("State:", state);
  
    if (errors.length > 0) {
      return false;
    } else {
      alert("everything good. submit form!");
      // Send POST Request....
    }
  }

  return (
    <>
      <div className="container">
        <Form onSubmit={handleSubmit} className="pt-3">

          <Form.Group as={Row} controlId="formHorizontalCompany">
            <Form.Label column sm={2}>
              Company Name
            </Form.Label>
            <Col sm={10}>
              <Form.Control 
                className={
                  hasError("companyname")
                    ? "form-control is-invalid"
                    : "form-control"
                } 
                name="companyname" 
                value={state.companyname} 
                type="text" 
                placeholder="Company Name" 
                onChange={ handleInputChange } 
              />
            </Col>
          </Form.Group>

          <Form.Group as={Row} controlId="formHorizontalFirstName">
            <Form.Label column sm={2}>
              First Name (optional)
            </Form.Label>
            <Col sm={10}>
              <Form.Control name="firstname" value={state.firstname} type="text" placeholder="First Name" onChange={ handleInputChange } />
            </Col>
          </Form.Group>

          <Form.Group as={Row} controlId="formHorizontalLastName">
            <Form.Label column sm={2}>
              Last Name
            </Form.Label>
            <Col sm={10}>
              <Form.Control name="lastname" value={state.lastname} type="text" placeholder="Last Name" onChange={ handleInputChange } />
            </Col>
          </Form.Group>

          <Form.Group as={Row} controlId="formHorizontalJobTitle">
            <Form.Label column sm={2}>
              Job Title
            </Form.Label>
            <Col sm={10}>
              <Form.Control name="jobtitle" value={state.jobtitle} type="text" placeholder="Job Title" onChange={ handleInputChange } />
            </Col>
          </Form.Group>

          <Form.Group as={Row} controlId="formHorizontalEmail">
            <Form.Label column sm={2}>
              Email Address
            </Form.Label>
            <Col sm={10}>
              <Form.Control 
                name="email"
                className={
                  hasError("email")
                    ? "form-control is-invalid"
                    : "form-control"
                }
                value={state.email} 
                type="email" 
                placeholder="Email" 
                onChange={ handleInputChange } 
              />
            </Col>
          </Form.Group>

          <Form.Group as={Row} controlId="formHorizontalPhoneNumber">
            <Form.Label column sm={2}>
              Phone Number
            </Form.Label>
            <Col sm={10}>
              <Form.Control 
                name="phonenumber"
                className={
                  hasError("phonenumber")
                    ? "form-control is-invalid"
                    : "form-control"
                }
                value={state.phonenumber}
                type="text"
                placeholder="Phone Name"
                onChange={ handleInputChange } 
              />
            </Col>
          </Form.Group>

          <Form.Group as={Row} controlId="formHorizontalCheck">
            <Col sm={{ span: 10, offset: 2 }}>
              <Form.Check label="The information collected will be used in accordance with our privacy plicy" />
            </Col>
          </Form.Group>

          <Form.Group as={Row}>
            <Col sm={{ span: 10, offset: 2 }}>
              <Button variant="secondary" type="submit">Request a Quote</Button>
            </Col>
          </Form.Group>
        </Form>
      </div>
    </>
  );
}

export default WPForm;
