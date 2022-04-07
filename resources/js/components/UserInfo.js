import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Form, Input, Divider, Table, Descriptions, Image, Button, Card, Space, message } from 'antd';
import { confirmAlert } from 'react-confirm-alert'
import 'react-confirm-alert/src/react-confirm-alert.css';



function UserInfo(props) {
    const [orderData, setOrderData] = useState()
    const [fields, setFields] = useState()
    console.log(props)
    //same as ComponentWillMount
    useEffect(() => {
        getData()
    }, [])

    const getData = async () => {
        const res = await axios.get('http://127.0.0.1:8000/api/PersonalInfo', {
            headers: {
                'Authorization': `Bearer ${props.jwt}`
            }
        })
        console.log(res.data)
        setOrderData(res.data)
        setFields([
            {
                name: ['name'],
                value: res.data.name,
            },
            {
                name: ['address'],
                value: res.data.address,
            },
            {
                name: ['email'],
                value: res.data.email,
            },
            {
                name: ['phone'],
                value: res.data.phone,
            }
        ])
    }

    const submit = (value) => {
        confirmAlert({
            title: 'Confirm to delete this account?',
            message: 'All of your record will be deleted as well!',
            buttons: [
                {
                    label: 'Yes',
                    onClick: () =>DeleteUser(value)
                },
                {
                    label: 'No',
                    onClick: () => message.success('Account unchanged')
                }
            ]
        });
    };

    const clearCart = async () => {
        let res = await axios.post(window.location.origin + '/clear')
        console.log('clearCart', res)
        if (res.status == 200) {
            location.reload();
        }
    }

  

    const DeleteUser = async (id) => {
        console.log(id)
        const res = await axios.post('http://127.0.0.1:8000/api/deleteUser', { 'id': id }, {
            headers: {
                'Authorization': `Bearer ${props.jwt}`
            }
        })
        message.warning('Account Deleted, Logging out!');
        await clearCart()
        window.location.replace(window.location.origin + "/login");
        console.log(res)
       
        
    }

    const onFinish = async (values) => {
        console.log('Success:', values);

        const dataArray = new FormData();
        dataArray.append("name", values.name);
        dataArray.append("email", values.email);
        dataArray.append("address", values.address);
        dataArray.append("phone", values.phone);
        
        dataArray.append("id", orderData.id);
        try {


            const res = await axios.post('http://127.0.0.1:8000/api/update', dataArray,
                {
                    headers: {
                        'Authorization': `Bearer ${props.jwt}`
                    }
                }
            )
            console.log('Profile Updated!', res)
            // console.log(values.concat(cart))
            if (res.status == 200) {
                message.success('Profile Updated!');

                // window.location.replace("http://127.0.0.1:8000/home");
            }
        } catch (error) {
            if (error.response) {
                if (error.response.data.errors.name !== undefined) {
                    for(let i=0; i<error.response.data.errors.name.length; i++)
                    {
                        message.error(error.response.data.errors.name[i] );
                    }
                }
                if (error.response.data.errors.address !== undefined) {
                    for(let i=0; i<error.response.data.errors.address.length; i++)
                    {
                        message.error(error.response.data.errors.address[i] );
                    }
                }
                if (error.response.data.errors.email !== undefined) {
                    for(let i=0; i<error.response.data.errors.email.length; i++)
                    {
                        message.error(error.response.data.errors.email[i] );
                    }
                }
                if (error.response.data.errors.phone !== undefined) {
                    for(let i=0; i<error.response.data.errors.phone.length; i++)
                    {
                        message.error(error.response.data.errors.phone[i] + '  Remember to add 60 infront');
                    }
                    
                }
            } else if (error.request) {
                // The request was made but no response was received
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                message.error(error);
            }
        }
    };
    const CustomizedForm = ({ fields }) => (
        <Space align="center" direction="vertical" style={{ display: 'flex', justifyContent: 'center', paddingTop: '5vh' }}>

            <Card title='Personal Information' style={{ width: '50vw' }}>

                <Form
                    name="global_state"
                    layout="horizontal"
                    fields={fields}
                    initialValues={{
                        remember: true,
                    }}

                    labelCol={{
                        span: 8,
                    }}
                    wrapperCol={{
                        span: 10,
                    }}
                    onFinish={onFinish}

                >
                    <Form.Item
                        name="name"
                        label="name"

                        rules={[
                            {

                                message: 'Username is required!',
                            },
                        ]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item
                        name="email"
                        label="email"
                        rules={[
                            {
                                required: true,
                                message: 'Email is required!',
                            },
                        ]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item
                        name="address"
                        label="address"
                        rules={[
                            {
                                required: true,
                                message: 'Address is required!',
                            },
                        ]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item
                        name="phone"
                        label="phone"
                        rules={[
                            {
                                required: true,
                                message: 'Phone is required!',
                            },
                        ]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        wrapperCol={{
                            offset: 8,
                            span: 16,
                        }}

                    >
                        <Button value="type1" type="primary" htmlType="submit" onClick={() => onFinish}>
                            Update
                        </Button>


                    </Form.Item>

                </Form>

                <Form
                    labelCol={{
                        span: 8,
                    }}
                    wrapperCol={{
                        span: 10,
                    }}
                >
                    <Form.Item
                        wrapperCol={{
                            offset: 8,
                            span: 16,
                        }}
                    >
                        <> <Button value="type2" type="danger" htmlType="submit" onClick={() => submit(orderData.id)}>
                            Delet account
                        </Button>
                        </>
                    </Form.Item>
                    </Form>
            </Card>
        </Space>


    );


    return (
        <>
            <CustomizedForm
                fields={fields}

            />

        </>


    );

}

export default UserInfo;

let root = document.getElementById('userinfo')
if (root) {
    ReactDOM.render(<UserInfo {...(root.dataset)} />, root);
}