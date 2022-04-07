import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Divider, Table, Descriptions, Image, Button, message,Form,Modal,Input,Alert } from 'antd';
import { EditFilled, DeleteFilled, LoadingOutlined, PlusOutlined } from '@ant-design/icons';
import { confirmAlert } from 'react-confirm-alert'
import 'react-confirm-alert/src/react-confirm-alert.css'; 


function Orders(props) {
    const [orderData, setOrderData] = useState()
    const [modalData, SetModalData] = useState();
    const [isModalVisible, setIsModalVisible] = useState(false);

    const modalToggle = () => {
        if (isModalVisible)
            SetModalData(null)
        setIsModalVisible(!isModalVisible)
    }

    const OpenModal = (data) => {
        SetModalData(data)
        modalToggle()
    }

    useEffect(() => {
        getData()
    }, [])
    const columns = [
        { title: 'id', dataIndex: 'id', key: 'id' },
        { title: 'reciever_name', dataIndex: 'reciever_name', key: 'reciever_name' },
        { title: 'reciever_phone', dataIndex: 'reciever_phone', key: 'reciever_phone' },
        { title: 'date_ordered', dataIndex: 'date_ordered', key: 'date_ordered' },
        { title: 'date_delivered', dataIndex: 'date_delivered', key: 'date_delivered' },
        { title: 'Status', dataIndex: 'status', key: 'status' },
        {
            title: 'Total',
            dataIndex: 'id',
            key: 'x',
            render: (text, record, index) => {
                let total = 0;
                record.items.forEach((item) => {
                    total += item.price * item.quantity
                })

                return (
                    'RM' + total

                )
            },
        }
        ,
        {
            title: 'Operation',
            render: (row) => {
                if (row['status'] == 'pending') {
                    return (
                        <div>
                        <Button type="primary" htmlType="submit" icon={<EditFilled />} onClick={() => OpenModal(row)}>
                            Update Order
                        </Button>
                        
                        <Button style={{marginLeft:'10px'}} type="danger" htmlType="submit" onClick={() => submit(row['id'])}>
                            Cancel Order
                        </Button>
                        </div>
                        
                    )
                }
                else if (row['status'] == 'delivered') {
                    return (
                        <> <strong>Order Accepted and delivered, no more action to perform</strong></>


                    )
                }
                



            }
        }
    ];
    const getData = async () => {
        const res = await axios.get(window.location.origin + '/api/orders', {
            headers: {
                'Authorization': `Bearer ${props.jwt}`
            }
        })
        console.log(res.data)

        //add key as id
        res.data.forEach(order => {
            order.key = order.id
        });
        setOrderData(res.data)
    }

    const deleteOrder = async (id) => {
        console.log(id)
        const res = await axios.post('http://127.0.0.1:8000/api/DeleteOrder', { 'id': id }, {
            headers: {
                'Authorization': `Bearer ${props.jwt}`
            }
        })
        message.success('Order cancelled')
        console.log(res)
        getData()
    }

    const submit = (value) => {
        confirmAlert({
          title: 'Confirm to delete order?',
          message: 'Are you sure to delete?.',
          buttons: [
            {
              label: 'Yes',
              onClick: () => deleteOrder(value)
            },
            {
              label: 'No',
              onClick: () => message.success('Order unchanged')
            }
          ]
        });
      };

    const onFinish = async (values) => {
        
        const dataArray = new FormData();
        values.id = modalData.id
        dataArray.append("reciever_name", values.reciever_name);
        dataArray.append("reciever_address", values.reciever_address);
        dataArray.append("reciever_phone", values.reciever_phone);
        dataArray.append("id", values.id);
        console.log(dataArray)

        values.image = dataArray
        console.log('onFin', values)
        try {
            const res = await axios.post(window.location.origin + '/api/UpdateOrder', dataArray,
                {
                    headers: {
                        'Authorization': `Bearer ${props.jwt}`
                    }
                }
            )
            if (res.status == 200) {
                message.success('Order Update Success!');
                // window.location.replace(window.location.origin + "/home");
                getData()
            }
        } catch (error) {
            if (error.response) {
                // Request made and server responded
                if(error.response.data.errors.reciever_name !==undefined)
                {
                    message.error(error.response.data.errors.reciever_name);
                }
                if(error.response.data.errors.reciever_phone !==undefined)
                {
                     message.error(error.response.data.errors.reciever_phone+' Remember to +60');
                }
                if(error.response.data.errors.reciever_address !==undefined)
                {
                     message.error(error.response.data.errors.reciever_address);
                }
               
            } else if (error.request) {
                // The request was made but no response was received
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                console.log('Error', error.message);
            }
        }
    };

    const onFinishFailed = (errorInfo) => {
        message.error('Order Update Error!');
    };
    return (
        <>
            <Table
                columns={columns}

                expandable={{
                    expandedRowRender: record => {
                        let total_price = 0;
                        return (
                            <>
                                {record.items.map(item => {
                                    total_price += item.price
                                    return (

                                        <div key={item.id}>
                                            <Descriptions bordered layout="vertical">

                                                <Descriptions.Item>
                                                    <Image src={`${window.location.origin}/uploads/images/${item.details.bouquetImage}`} width='150'></Image>
                                                </Descriptions.Item>
                                                <Descriptions.Item label="Name :">{item.details.bouequetName}</Descriptions.Item>
                                                <Descriptions.Item label="Description :">{item.details.bouequetDescription}</Descriptions.Item>
                                                <Descriptions.Item label="Type :">{item.details.type}</Descriptions.Item>
                                                <Descriptions.Item label="Quantity :">{item.quantity}</Descriptions.Item>
                                                <Descriptions.Item label="Unit Price :">RM{item.price}</Descriptions.Item>
                                                <Descriptions.Item label="Total Price :">RM{item.price * item.quantity}</Descriptions.Item>

                                            </Descriptions>

                                            <Divider></Divider>

                                        </div>

                                    )
                                })}
                            </>
                        )
                    },
                    rowExpandable: record => record.name !== 'Not Expandable',
                }}
                dataSource={orderData}

            />

{
                modalData &&
                <Modal title="Edit Order" visible={isModalVisible} onOk={modalToggle} onCancel={modalToggle}>

                    <Form
                        name="basic"
                        onFinish={onFinish}
                        onFinishFailed={onFinishFailed}
                        initialValues={{
                            reciever_name: modalData.reciever_name,
                            reciever_address: modalData.reciever_address, 
                            reciever_phone: modalData.reciever_phone
                        }}
                        labelCol={{
                            span: 8,
                        }}
                        wrapperCol={{
                            span: 10,
                        }}
                    >
                        <Form.Item
                            label="Reciever Name"
                            name="reciever_name"
                            rules={[{ required: true, message: 'Please input reciever name!' }]}
                        >
                            <Input />
                        </Form.Item>

                        <Form.Item
                            label="Reciever Address"
                            name="reciever_address"
                            rules={[{ required: true, message: 'Please input reciver address!' }]}
                        >
                            <Input />
                        </Form.Item>

                        <Form.Item
                            label="Reciever Phone"
                            name="reciever_phone"
                            rules={[{ required: true, message: 'Please input reciever phone!' }]}
                        >
                            <Input />
                        </Form.Item>

                        
                       
                        <Form.Item wrapperCol={{ offset: 8, span: 16 }}>
                            <Button type="primary" htmlType="submit">
                                Update
                            </Button>
                        </Form.Item>
                    </Form>
                </Modal>
            }
        </>
    );
}

export default Orders;

let root = document.getElementById('orders')
if (root) {
    ReactDOM.render(<Orders {...(root.dataset)} />, root);
}