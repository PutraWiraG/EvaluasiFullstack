import request from 'supertest';
import { expect } from 'chai';

// Ganti URL sesuai jalur API Laravel kamu
const api = request('http://127.0.0.1:8000/api');

let userId = null;

describe('User API Laravel', () => {

    it('should get all users', async () => {
        const res = await api.get('/users');
        expect(res.status).to.equal(200);
        expect(res.body).to.have.property('data');
        expect(res.body.data).to.be.an('array');
        });

    it('should create a new user', async () => {
        const res = await api.post('/users').send({
        name: 'Test User',
        email: `test${Date.now()}@example.com`,
        age: 22,
        });

        expect(res.status).to.equal(200);
        expect(res.body).to.have.property('data');
        userId = res.body.data.id;
    });

    it('should get the created user', async () => {
        const res = await api.get(`/users/${userId}`);
        expect(res.status).to.equal(200);
        expect(res.body.data).to.have.property('id', userId);
    });

    it('should update the user', async () => {
        const res = await api.put(`/users/${userId}`).send({
          name: 'Updated User',
          email: `updated${Date.now()}@example.com`,
          age: 25,
        });

        expect(res.status).to.equal(200);
        expect(res.body.data).to.have.property('name', 'Updated User');
    });

    it('should delete the user', async () => {
        const res = await api.delete(`/users/${userId}`);
        expect(res.status).to.equal(200);
        expect(res.body).to.have.property('message').that.includes('Berhasil Hapus');
    });

});
